<?php
session_start();
require_once '../Modelo/database.php';

if (!isset($_SESSION['rol']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'vendedor')) {
    header('Location: ../Vista/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_juego = $_POST['id_juego'];
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $db = new Database();
    $conn = $db->getConnection();

    // Verificación de permisos
    if ($_SESSION['rol'] === 'vendedor') {
        $stmt = $conn->prepare("SELECT id_vendedor FROM Juegos WHERE id_juego = ?");
        $stmt->execute([$id_juego]);
        $juego = $stmt->fetch();
        if (!$juego || $juego['id_vendedor'] !== $_SESSION['id_usuario']) {
            header("Location: ../Vista/panel.php?error=no_autorizado");
            exit();
        }
    }

    $stmt = $conn->prepare("UPDATE Juegos SET titulo = ?, genero = ?, precio = ?, stock = ? WHERE id_juego = ?");

    try {
        $stmt->execute([$titulo, $genero, $precio, $stock, $id_juego]);
        header("Location: ../Vista/panel.php?exito=juego_editado");
    } catch (PDOException $e) {
        header("Location: ../Vista/editar_juego.php?id=$id_juego&error=db_error");
    }
    exit();
}
?>
