<?php
include 'header.php';
require_once '../Modelo/database.php';

// Proteger ruta - solo admin puede ver reportes
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$db = new Database();
$conn = $db->getConnection();

// Reporte 1: Ventas totales por vendedor
$stmt1 = $conn->prepare("
    SELECT u.nombre, SUM(t.total) as total_ventas
    FROM Transacciones t
    JOIN Detalle_Transaccion dt ON t.id_transaccion = dt.id_transaccion
    JOIN Juegos j ON dt.id_juego = j.id_juego
    JOIN Usuarios u ON j.id_vendedor = u.id_usuario
    GROUP BY u.nombre
    ORDER BY total_ventas DESC
");
$stmt1->execute();
$ventas_vendedor = $stmt1->fetchAll(PDO::FETCH_ASSOC);

// Reporte 2: Juegos más vendidos
$stmt2 = $conn->prepare("
    SELECT j.titulo, SUM(dt.cantidad) as unidades_vendidas
    FROM Detalle_Transaccion dt
    JOIN Juegos j ON dt.id_juego = j.id_juego
    GROUP BY j.titulo
    ORDER BY unidades_vendidas DESC
    LIMIT 10
");
$stmt2->execute();
$juegos_vendidos = $stmt2->fetchAll(PDO::FETCH_ASSOC);

?>

<h2 class="mb-4">Reportes y Estadísticas</h2>

<!-- Ventas por Vendedor -->
<div class="card mb-4">
    <div class="card-header">
        <h4>Ventas Totales por Vendedor</h4>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Vendedor</th>
                    <th>Total Vendido</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ventas_vendedor as $venta): ?>
                <tr>
                    <td><?php echo htmlspecialchars($venta['nombre']); ?></td>
                    <td>$<?php echo number_format($venta['total_ventas'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Juegos más Vendidos -->
<div class="card">
    <div class="card-header">
        <h4>Top 10 Juegos Más Vendidos</h4>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Juego</th>
                    <th>Unidades Vendidas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($juegos_vendidos as $juego): ?>
                <tr>
                    <td><?php echo htmlspecialchars($juego['titulo']); ?></td>
                    <td><?php echo $juego['unidades_vendidas']; ?></td>
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
