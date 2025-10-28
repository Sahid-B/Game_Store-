<?php
// GameStore_NoDB/Vista/reportes.php
include 'header.php';
require_once '../Modelo/memoria.php';

// Protect route - only admin can view reports
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Report 1: Total sales per seller
$ventas_vendedor = [];
foreach ($_SESSION['db']['transacciones'] as $transaccion) {
    foreach ($_SESSION['db']['detalle_transacciones'] as $detalle) {
        if ($detalle['id_transaccion'] == $transaccion['id_transaccion']) {
            $id_juego = $detalle['id_juego'];
            if (isset($_SESSION['db']['juegos'][$id_juego])) {
                $id_vendedor = $_SESSION['db']['juegos'][$id_juego]['id_vendedor'];
                $nombre_vendedor = $_SESSION['db']['usuarios'][$id_vendedor]['nombre'];

                if (!isset($ventas_vendedor[$nombre_vendedor])) {
                    $ventas_vendedor[$nombre_vendedor] = 0;
                }
                $ventas_vendedor[$nombre_vendedor] += $detalle['subtotal'];
            }
        }
    }
}
arsort($ventas_vendedor);

// Report 2: Best-selling games
$juegos_vendidos = [];
foreach ($_SESSION['db']['detalle_transacciones'] as $detalle) {
    $id_juego = $detalle['id_juego'];
    $titulo_juego = $_SESSION['db']['juegos'][$id_juego]['titulo'] ?? 'Juego Eliminado';

    if (!isset($juegos_vendidos[$titulo_juego])) {
        $juegos_vendidos[$titulo_juego] = 0;
    }
    $juegos_vendidos[$titulo_juego] += $detalle['cantidad'];
}
arsort($juegos_vendidos);
$juegos_vendidos = array_slice($juegos_vendidos, 0, 10);
?>

<h2 class="mb-4">Reportes y Estadísticas</h2>

<!-- Sales by Seller -->
<div class="card mb-4">
    <div class="card-header"><h4>Ventas Totales por Vendedor</h4></div>
    <div class="card-body">
        <table class="table">
            <thead><tr><th>Vendedor</th><th>Total Vendido</th></tr></thead>
            <tbody>
                <?php foreach ($ventas_vendedor as $vendedor => $total): ?>
                <tr>
                    <td><?php echo htmlspecialchars($vendedor); ?></td>
                    <td>$<?php echo number_format($total, 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Best-Selling Games -->
<div class="card">
    <div class="card-header"><h4>Top 10 Juegos Más Vendidos</h4></div>
    <div class="card-body">
        <table class="table">
            <thead><tr><th>Juego</th><th>Unidades Vendidas</th></tr></thead>
            <tbody>
                <?php foreach ($juegos_vendidos as $juego => $unidades): ?>
                <tr>
                    <td><?php echo htmlspecialchars($juego); ?></td>
                    <td><?php echo $unidades; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    <a href="panel.php" class="btn btn-secondary">Volver al Panel</a>
</div>

<?php include 'footer.php'; ?>
