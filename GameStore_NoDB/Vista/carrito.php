<?php
include 'header.php';
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
    header('Location: login.php');
    exit();
}
$carrito = $_SESSION['carrito'] ?? [];
$total = 0;
?>

<h1 class="mb-4">Carrito de Compras</h1>

<div class="row">
    <div class="col-lg-8">
        <?php if (empty($carrito)): ?>
            <div class="card card-body text-center">
                <p class="mb-0">Tu carrito está vacío. <a href="catalogo.php" class="text-neon">Explora nuestro catálogo</a>.</p>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Juego</th>
                                    <th>Precio</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-end">Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($carrito as $id => $juego): ?>
                                    <?php
                                    $subtotal = $juego['precio'] * $juego['cantidad'];
                                    $total += $subtotal;
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($juego['titulo']); ?></td>
                                        <td class="text-neon">$<?php echo number_format($juego['precio'], 2); ?></td>
                                        <td class="text-center">
                                            <form action="../Controlador/carrito_acciones.php?accion=actualizar&id=<?php echo $id; ?>" method="post" class="d-inline-flex">
                                                <input type="number" name="cantidad" value="<?php echo $juego['cantidad']; ?>" min="1" max="<?php echo $juego['stock']; ?>" class="form-control form-control-sm" style="width: 70px;">
                                                <button type="submit" class="btn btn-secondary btn-sm ms-2">OK</button>
                                            </form>
                                        </td>
                                        <td class="text-end text-neon">$<?php echo number_format($subtotal, 2); ?></td>
                                        <td class="text-end">
                                            <a href="../Controlador/carrito_acciones.php?accion=eliminar&id=<?php echo $id; ?>" class="btn btn-danger btn-sm">X</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Resumen de la Compra</h4>
                <div class="d-flex justify-content-between">
                    <h5>Total</h5>
                    <h5 class="text-neon">$<?php echo number_format($total, 2); ?></h5>
                </div>
                <hr>
                <div class="d-grid gap-2">
                    <a href="../Controlador/procesar_compra.php" class="btn btn-primary">Procesar Compra</a>
                    <a href="catalogo.php" class="btn btn-secondary">Seguir Comprando</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<style>.text-neon { color: var(--neon-accent); font-weight: bold; }</style>
