<?php
// GameStore_NoDB/Vista/mis_compras.php
include 'header.php';
require_once '../Modelo/memoria.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
    header('Location: login.php');
    exit();
}

$id_cliente = $_SESSION['id_usuario'];
$historial = [];

// Filter transactions for the current client
foreach ($_SESSION['db']['transacciones'] as $transaccion) {
    if ($transaccion['id_cliente'] == $id_cliente) {
        $detalles_completos = [];
        // Find and attach details for each transaction
        foreach ($_SESSION['db']['detalle_transacciones'] as $detalle) {
            if ($detalle['id_transaccion'] == $transaccion['id_transaccion']) {
                $juego_info = $_SESSION['db']['juegos'][$detalle['id_juego']] ?? ['titulo' => 'Juego Eliminado'];
                $detalle['titulo'] = $juego_info['titulo'];
                $detalles_completos[] = $detalle;
            }
        }
        $transaccion['detalles'] = $detalles_completos;
        $historial[$transaccion['id_transaccion']] = $transaccion;
    }
}
// Sort by date descending
krsort($historial);
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
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $id_transaccion; ?>">
                        <strong>Transacción #<?php echo $id_transaccion; ?></strong> -
                        Fecha: <?php echo date('d/m/Y H:i', strtotime($transaccion['fecha'])); ?> -
                        Total: $<?php echo number_format($transaccion['total'], 2); ?>
                    </button>
                </h2>
                <div id="collapse-<?php echo $id_transaccion; ?>" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <table class="table table-sm">
                            <thead>
                                <tr><th>Juego</th><th>Cantidad</th><th>Subtotal</th></tr>
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
