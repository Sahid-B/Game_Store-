<?php
// GameStore_NoDB/Controlador/carrito_acciones.php
require_once '../Modelo/memoria.php';

if (!isset($_GET['accion']) || !isset($_SESSION['id_usuario'])) {
    header('Location: ../Vista/login.php');
    exit();
}

$accion = $_GET['accion'];
$id_juego = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Initialize cart if it doesn't exist
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Get game info from session
$juego = isset($_SESSION['db']['juegos'][$id_juego]) ? $_SESSION['db']['juegos'][$id_juego] : null;

if (!$juego) {
    header('Location: ../Vista/catalogo.php?status=not_found');
    exit();
}

switch ($accion) {
    case 'agregar':
        if (isset($_SESSION['carrito'][$id_juego])) {
            if ($_SESSION['carrito'][$id_juego]['cantidad'] < $juego['stock']) {
                $_SESSION['carrito'][$id_juego]['cantidad']++;
            }
        } else {
            $_SESSION['carrito'][$id_juego] = [
                "titulo" => $juego['titulo'],
                "precio" => $juego['precio'],
                "cantidad" => 1,
                "stock" => $juego['stock']
            ];
        }
        header('Location: ../Vista/catalogo.php?status=added');
        break;

    case 'eliminar':
        if (isset($_SESSION['carrito'][$id_juego])) {
            unset($_SESSION['carrito'][$id_juego]);
        }
        header('Location: ../Vista/carrito.php?status=removed');
        break;

    case 'actualizar':
        $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;
        if (isset($_SESSION['carrito'][$id_juego]) && $cantidad > 0) {
            $_SESSION['carrito'][$id_juego]['cantidad'] = min($cantidad, $juego['stock']);
        }
        header('Location: ../Vista/carrito.php');
        break;

    default:
        header('Location: ../Vista/catalogo.php');
        break;
}
exit();
?>
