<?php
session_start();
require_once '../Modelo/database.php';

if (!isset($_SESSION['rol']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'vendedor')) {
    header('Location: ../Vista/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $id_vendedor = $_SESSION['id_usuario'];

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("INSERT INTO Juegos (titulo, genero, precio, stock, id_vendedor) VALUES (?, ?, ?, ?, ?)");

    try {
        $stmt->execute([$titulo, $genero, $precio, $stock, $id_vendedor]);
        header("Location: ../Vista/panel.php?exito=juego_agregado");
    } catch (PDOException $e) {
        header("Location: ../Vista/agregar_juego.php?error=db_error");
    }
    exit();
}
?>
