<?php
session_start();
require_once '../Modelo/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT id_usuario, nombre, contraseña, rol FROM Usuarios WHERE correo = ?");
    $stmt->execute([$correo]);

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($contraseña, $usuario['contraseña'])) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            if ($usuario['rol'] === 'admin' || $usuario['rol'] === 'vendedor') {
                header("Location: ../Vista/panel.php");
            } else {
                header("Location: ../Vista/catalogo.php");
            }
            exit();
        }
    }

    header("Location: ../Vista/login.php?error=1");
    exit();
}
?>
