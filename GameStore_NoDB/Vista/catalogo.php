<?php
include 'header.php';
require_once '../Modelo/memoria.php';

// Search and filter logic
$busqueda = isset($_GET['busqueda']) ? strtolower($_GET['busqueda']) : '';
$juegos_disponibles = [];
foreach ($_SESSION['db']['juegos'] as $juego) {
    if ($juego['stock'] > 0) {
        if (empty($busqueda) || strpos(strtolower($juego['titulo']), $busqueda) !== false || strpos(strtolower($juego['genero']), $busqueda) !== false) {
            $juegos_disponibles[] = $juego;
        }
    }
}

function render_stars($rating) {
    $html = '<div class="star-rating">';
    for ($i = 1; $i <= 5; $i++) {
        $html .= $i <= $rating ? '★' : '☆';
    }
    $html .= '</div>';
    return $html;
}
?>

<style>
.game-card {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.4s ease;
    border: 1px solid transparent;
}
.game-card:hover {
    transform: scale(1.05);
    box-shadow: 0 0 25px var(--card-border);
    border-color: var(--neon-accent);
}
.game-card-img-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(to top, rgba(15, 36, 60, 0.9) 20%, transparent 60%);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 1rem;
}
.game-card:hover .game-card-img-overlay { opacity: 1; }
.game-card-title { font-weight: 700; }
.game-card-price { color: var(--neon-accent); font-weight: 700; font-size: 1.2rem; }
.star-rating { color: #ffc107; }
.btn-add-cart { width: 100%; }
</style>

<div class="container mt-5">
    <h1 class="mb-4">Catálogo de Juegos</h1>

    <!-- Search Form -->
    <form method="GET" action="catalogo.php" class="mb-5">
        <div class="input-group">
            <input type="text" name="busqueda" class="form-control form-control-lg" placeholder="Buscar por título o género..." value="<?php echo htmlspecialchars($busqueda); ?>">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>

    <!-- Games Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
        <?php foreach ($juegos_disponibles as $juego): ?>
            <div class="col">
                <div class="card game-card h-100">
                    <img src="<?php echo $juego['image']; ?>" class="card-img" alt="<?php echo htmlspecialchars($juego['titulo']); ?>">
                    <div class="game-card-img-overlay">
                        <h5 class="card-title text-white game-card-title"><?php echo htmlspecialchars($juego['titulo']); ?></h5>
                        <?php echo render_stars($juego['rating']); ?>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="game-card-price">$<?php echo htmlspecialchars($juego['precio']); ?></span>
                            <a href="../Controlador/carrito_acciones.php?accion=agregar&id=<?php echo $juego['id_juego']; ?>" class="btn btn-primary btn-sm">Añadir</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
