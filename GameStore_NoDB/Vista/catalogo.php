<?php
// GameStore_NoDB/Vista/catalogo.php
include 'header.php';
require_once '../Modelo/memoria.php';

// Redirect if not logged in as a client
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
    header('Location: login.php');
    exit();
}

// Search logic
$busqueda = isset($_GET['busqueda']) ? strtolower($_GET['busqueda']) : '';
$juegos_disponibles = [];

foreach ($_SESSION['db']['juegos'] as $juego) {
    if ($juego['stock'] > 0) {
        if (empty($busqueda) || strpos(strtolower($juego['titulo']), $busqueda) !== false || strpos(strtolower($juego['genero']), $busqueda) !== false) {
            $juegos_disponibles[] = $juego;
        }
    }
}
?>

<h2 class="mb-4">Catálogo de Juegos</h2>

<!-- Search Form -->
<form method="GET" action="catalogo.php" class="mb-4">
    <div class="input-group">
        <input type="text" name="busqueda" class="form-control" placeholder="Buscar por título o género..." value="<?php echo htmlspecialchars($busqueda); ?>">
        <button class="btn btn-primary" type="submit">Buscar</button>
    </div>
</form>

<!-- Cart Message -->
<?php if (isset($_GET['status']) && $_GET['status'] == 'added'): ?>
    <div class="alert alert-success">¡Juego añadido al carrito!</div>
<?php endif; ?>

<div class="row">
    <?php if (count($juegos_disponibles) > 0): ?>
        <?php foreach ($juegos_disponibles as $juego): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img class="card-img-top" src="https://via.placeholder.com/500x325" alt="<?php echo htmlspecialchars($juego['titulo']); ?>">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo htmlspecialchars($juego['titulo']); ?></h4>
                        <h5>$<?php echo htmlspecialchars($juego['precio']); ?></h5>
                        <p class="card-text">
                            <strong>Género:</strong> <?php echo htmlspecialchars($juego['genero']); ?><br>
                            <strong>Disponibles:</strong> <?php echo htmlspecialchars($juego['stock']); ?>
                        </p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="../Controlador/carrito_acciones.php?accion=agregar&id=<?php echo $juego['id_juego']; ?>" class="btn btn-primary">Agregar al Carrito</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <p class="text-center">No se encontraron juegos.</p>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
