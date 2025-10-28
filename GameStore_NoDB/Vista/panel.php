<?php
// GameStore_NoDB/Vista/panel.php
include 'header.php';
require_once '../Modelo/memoria.php';

// Protect route
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'vendedor')) {
    header('Location: login.php');
    exit();
}

$es_admin = ($_SESSION['rol'] === 'admin');
$id_vendedor_actual = $_SESSION['id_usuario'];
$juegos_panel = [];

foreach ($_SESSION['db']['juegos'] as $juego) {
    if ($es_admin || $juego['id_vendedor'] == $id_vendedor_actual) {
        $vendedor_nombre = 'N/A';
        if (isset($_SESSION['db']['usuarios'][$juego['id_vendedor']])) {
            $vendedor_nombre = $_SESSION['db']['usuarios'][$juego['id_vendedor']]['nombre'];
        }
        $juego['vendedor_nombre'] = $vendedor_nombre;
        $juegos_panel[] = $juego;
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Panel de Administración de Juegos</h2>
    <a href="agregar_juego.php" class="btn btn-success">Agregar Nuevo Juego</a>
</div>

<?php if (isset($_GET['exito'])): ?>
    <div class="alert alert-success">Operación realizada con éxito.</div>
<?php endif; ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">Error: <?php echo htmlspecialchars($_GET['error']); ?></div>
<?php endif; ?>


<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Género</th>
                <th>Precio</th>
                <th>Stock</th>
                <?php if ($es_admin): ?>
                    <th>Vendedor</th>
                <?php endif; ?>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($juegos_panel as $juego): ?>
                <tr>
                    <td><?php echo htmlspecialchars($juego['id_juego']); ?></td>
                    <td><?php echo htmlspecialchars($juego['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($juego['genero']); ?></td>
                    <td>$<?php echo htmlspecialchars($juego['precio']); ?></td>
                    <td><?php echo htmlspecialchars($juego['stock']); ?></td>
                    <?php if ($es_admin): ?>
                        <td><?php echo htmlspecialchars($juego['vendedor_nombre']); ?></td>
                    <?php endif; ?>
                    <td>
                        <a href="editar_juego.php?id=<?php echo $juego['id_juego']; ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="../Controlador/eliminar_juego.php?id=<?php echo $juego['id_juego']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
