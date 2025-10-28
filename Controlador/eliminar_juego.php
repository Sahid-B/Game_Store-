<?php
session_start();
require_once '../Modelo/database.php';

if (!isset($_SESSION['rol']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'vendedor')) {
    header('Location: ../Vista/login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: ../Vista/panel.php');
    exit();
}

$id_juego = $_GET['id'];
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

// Para mantener integridad referencial, primero se deberían eliminar detalles de transacciones,
// o marcarlos como "no disponibles". Por simplicidad, aquí solo eliminamos el juego.
// En un sistema real, esto requeriría una lógica más compleja (ej. borrado suave).

$stmt = $conn->prepare("DELETE FROM Juegos WHERE id_juego = ?");

try {
    $stmt->execute([$id_juego]);
    header("Location: ../Vista/panel.php?exito=juego_eliminado");
} catch (PDOException $e) {
    // Si hay transacciones asociadas, la FK constraint fallará.
    header("Location: ../Vista/panel.php?error=no_se_puede_eliminar");
}
exit();
?>
