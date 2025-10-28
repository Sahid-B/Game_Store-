<?php
require_once '../Modelo/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'];

    $db = new Database();
    $conn = $db->getConnection();

    try {
        $stmt = $conn->prepare("INSERT INTO Usuarios (nombre, correo, contraseña, rol) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $correo, $contraseña, $rol]);

        header("Location: ../Vista/login.php?registro=exitoso");
        exit();
    } catch (PDOException $e) {
        // Manejar correo duplicado
        if ($e->getCode() == 23000) {
             header("Location: ../Vista/registro.php?error=correo_existente");
        } else {
             header("Location: ../Vista/registro.php?error=db_error");
        }
        exit();
    }
}
?>
