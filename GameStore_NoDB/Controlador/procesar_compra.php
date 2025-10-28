<?php
// GameStore_NoDB/Controlador/procesar_compra.php
require_once '../Modelo/memoria.php';

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

// 1. Create a new transaction
$id_transaccion = $_SESSION['db']['next_transaccion_id']++;
$_SESSION['db']['transacciones'][$id_transaccion] = [
    'id_transaccion' => $id_transaccion,
    'id_cliente' => $id_cliente,
    'fecha' => date('Y-m-d H:i:s'),
    'total' => $total
];

// 2. Add transaction details and update stock
foreach ($carrito as $id_juego => $item) {
    $subtotal = $item['precio'] * $item['cantidad'];

    $id_detalle = $_SESSION['db']['next_detalle_id']++;
    $_SESSION['db']['detalle_transacciones'][$id_detalle] = [
        'id_detalle' => $id_detalle,
        'id_transaccion' => $id_transaccion,
        'id_juego' => $id_juego,
        'cantidad' => $item['cantidad'],
        'subtotal' => $subtotal
    ];

    // Update stock
    if (isset($_SESSION['db']['juegos'][$id_juego])) {
        $_SESSION['db']['juegos'][$id_juego]['stock'] -= $item['cantidad'];
    }
}

// Clear the cart
unset($_SESSION['carrito']);

header("Location: ../Vista/mis_compras.php?compra=exitosa");
exit();
?>
