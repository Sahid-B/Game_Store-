<?php
session_start();
require_once '../Modelo/database.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente' || empty($_SESSION['carrito'])) {
    header('Location: ../Vista/catalogo.php');
    exit();
}

$id_cliente = $_SESSION['id_usuario'];
$carrito = $_SESSION['carrito'];
$total = 0;

foreach ($carrito as $item) {
    $total += $item['precio'] * $item['cantidad'];
}

$db = new Database();
$conn = $db->getConnection();

try {
    $conn->beginTransaction();

    // 1. Insertar en la tabla de Transacciones
    $stmt1 = $conn->prepare("INSERT INTO Transacciones (id_cliente, total) VALUES (?, ?)");
    $stmt1->execute([$id_cliente, $total]);
    $id_transaccion = $conn->lastInsertId();

    // 2. Insertar cada juego en Detalle_Transaccion y actualizar stock
    $stmt2 = $conn->prepare("INSERT INTO Detalle_Transaccion (id_transaccion, id_juego, cantidad, subtotal) VALUES (?, ?, ?, ?)");
    $stmt3 = $conn->prepare("UPDATE Juegos SET stock = stock - ? WHERE id_juego = ?");

    foreach ($carrito as $id_juego => $item) {
        $subtotal = $item['precio'] * $item['cantidad'];
        // Insertar detalle
        $stmt2->execute([$id_transaccion, $id_juego, $item['cantidad'], $subtotal]);
        // Actualizar stock
        $stmt3->execute([$item['cantidad'], $id_juego]);
    }

    $conn->commit();

    // Limpiar carrito
    unset($_SESSION['carrito']);

    header("Location: ../Vista/mis_compras.php?compra=exitosa");

} catch (Exception $e) {
    $conn->rollBack();
    // Podrías registrar el error en un log
    header("Location: ../Vista/carrito.php?error=procesar_compra");
}

exit();
?>
