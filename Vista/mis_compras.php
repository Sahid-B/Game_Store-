<?php
include 'header.php';
require_once '../Modelo/database.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
    header('Location: login.php');
    exit();
}

$id_cliente = $_SESSION['id_usuario'];
$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("
    SELECT
        t.id_transaccion,
        t.fecha,
        t.total,
        j.titulo,
        dt.cantidad,
        dt.subtotal
    FROM Transacciones t
    JOIN Detalle_Transaccion dt ON t.id_transaccion = dt.id_transaccion
    JOIN Juegos j ON dt.id_juego = j.id_juego
    WHERE t.id_cliente = ?
    ORDER BY t.fecha DESC
");
$stmt->execute([$id_cliente]);
$compras = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Agrupar resultados por transacción
$historial = [];
foreach ($compras as $compra) {
    $historial[$compra['id_transaccion']]['fecha'] = $compra['fecha'];
    $historial[$compra['id_transaccion']]['total'] = $compra['total'];
    $historial[$compra['id_transaccion']]['detalles'][] = $compra;
}

?>

<h2 class="mb-4">Mi Historial de Compras</h2>

<?php if (isset($_GET['compra']) && $_GET['compra'] === 'exitosa'): ?>
    <div class="alert alert-success">¡Gracias por tu compra!</div>
<?php endif; ?>

<?php if (empty($historial)): ?>
    <p>Aún no has realizado ninguna compra.</p>
<?php else: ?>
    <div class="accordion" id="accordionCompras">
        <?php foreach ($historial as $id_transaccion => $transaccion): ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading-<?php echo $id_transaccion; ?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $id_transaccion; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $id_transaccion; ?>">
                        <strong>Transacción #<?php echo $id_transaccion; ?></strong> -
                        Fecha: <?php echo date('d/m/Y H:i', strtotime($transaccion['fecha'])); ?> -
                        Total: $<?php echo number_format($transaccion['total'], 2); ?>
                    </button>
                </h2>
                <div id="collapse-<?php echo $id_transaccion; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $id_transaccion; ?>" data-bs-parent="#accordionCompras">
                    <div class="accordion-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Juego</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transaccion['detalles'] as $detalle): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($detalle['titulo']); ?></td>
                                        <td><?php echo $detalle['cantidad']; ?></td>
                                        <td>$<?php echo number_format($detalle['subtotal'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="mt-4">
    <a href="catalogo.php" class="btn btn-primary">Volver al Catálogo</a>
</div>

<?php include 'footer.php'; ?>
