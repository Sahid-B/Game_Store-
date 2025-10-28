<?php
session_start();
require_once '../Modelo/database.php';

if (!isset($_GET['accion']) || !isset($_SESSION['id_usuario'])) {
    header('Location: ../Vista/login.php');
    exit();
}

$accion = $_GET['accion'];
$id_juego = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Conectar a BD para obtener info del juego
$db = new Database();
$conn = $db->getConnection();
$stmt = $conn->prepare("SELECT id_juego, titulo, precio, stock FROM Juegos WHERE id_juego = ?");
$stmt->execute([$id_juego]);
$juego = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$juego) {
    header('Location: ../Vista/catalogo.php?status=not_found');
    exit();
}

switch ($accion) {
    case 'agregar':
        // Si el juego ya está en el carrito, aumenta la cantidad
        if (isset($_SESSION['carrito'][$id_juego])) {
            // No exceder el stock
            if ($_SESSION['carrito'][$id_juego]['cantidad'] < $juego['stock']) {
                $_SESSION['carrito'][$id_juego]['cantidad']++;
            }
        } else {
            // Añadir nuevo juego al carrito
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
            // Asegurar que la cantidad no exceda el stock
            if ($cantidad <= $juego['stock']) {
                $_SESSION['carrito'][$id_juego]['cantidad'] = $cantidad;
            } else {
                $_SESSION['carrito'][$id_juego]['cantidad'] = $juego['stock'];
            }
        }
        header('Location: ../Vista/carrito.php');
        break;

    default:
        header('Location: ../Vista/catalogo.php');
        break;
}
exit();
?>