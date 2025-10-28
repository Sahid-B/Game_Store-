<?php
include 'header.php';
require_once '../Modelo/database.php';

// Proteger ruta
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'vendedor')) {
    header('Location: login.php');
    exit();
}

$db = new Database();
$conn = $db->getConnection();

$es_admin = ($_SESSION['rol'] === 'admin');
$id_vendedor_actual = $_SESSION['id_usuario'];

// Admin ve todos los juegos, Vendedor solo los suyos
if ($es_admin) {
    $stmt = $conn->prepare("SELECT j.*, u.nombre as vendedor_nombre FROM Juegos j LEFT JOIN Usuarios u ON j.id_vendedor = u.id_usuario");
} else {
    $stmt = $conn->prepare("SELECT * FROM Juegos WHERE id_vendedor = ?");
    $stmt->bindParam(1, $id_vendedor_actual);
}
$stmt->execute();
$juegos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Panel de Administración de Juegos</h2>
    <a href="agregar_juego.php" class="btn btn-success">Agregar Nuevo Juego</a>
</div>

<?php if (isset($_GET['exito'])): ?>
    <div class="alert alert-success">Operación realizada con éxito.</div>
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
            <?php foreach ($juegos as $juego): ?>
                <tr>
                    <td><?php echo htmlspecialchars($juego['id_juego']); ?></td>
                    <td><?php echo htmlspecialchars($juego['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($juego['genero']); ?></td>
                    <td>$<?php echo htmlspecialchars($juego['precio']); ?></td>
                    <td><?php echo htmlspecialchars($juego['stock']); ?></td>
                    <?php if ($es_admin): ?>
                        <td><?php echo htmlspecialchars($juego['vendedor_nombre'] ?? 'N/A'); ?></td>
                    <?php endif; ?>
                    <td>
                        <a href="editar_juego.php?id=<?php echo $juego['id_juego']; ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="../Controlador/eliminar_juego.php?id=<?php echo $juego['id_juego']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este juego?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
