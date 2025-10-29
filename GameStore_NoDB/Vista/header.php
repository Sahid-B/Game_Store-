<?php
// GameStore_NoDB/Vista/header.php
require_once '../Modelo/memoria.php'; // Ensures session and data are initialized
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameStore+ | Modern Gaming</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">GameStore+</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="catalogo.php">Catálogo</a></li>
                <?php if (isset($_SESSION['id_usuario'])): ?>
                    <li class="nav-item nav-link text-white-50">Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?></li>
                    <?php if ($_SESSION['rol'] === 'cliente'): ?>
                        <li class="nav-item"><a class="nav-link" href="carrito.php">Carrito</a></li>
                        <li class="nav-item"><a class="nav-link" href="mis_compras.php">Mis Compras</a></li>
                    <?php endif; ?>
                    <?php if ($_SESSION['rol'] === 'admin' || $_SESSION['rol'] === 'vendedor'): ?>
                        <li class="nav-item"><a class="nav-link" href="panel.php">Panel</a></li>
                         <?php if ($_SESSION['rol'] === 'admin'): ?>
                             <li class="nav-item"><a class="nav-link" href="reportes.php">Reportes</a></li>
                         <?php endif; ?>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="../Controlador/logout.php">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="registro.php">Registro</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5 mb-5">
