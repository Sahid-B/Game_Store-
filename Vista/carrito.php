<?php
include 'header.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
    header('Location: login.php');
    exit();
}

$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
$total = 0;
?>

<h2 class="mb-4">Carrito de Compras</h2>

<?php if (empty($carrito)): ?>
    <div class="alert alert-info">Tu carrito está vacío. <a href="catalogo.php">¡Ve al catálogo para agregar juegos!</a></div>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Juego</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acción</th>
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
                    <td>$<?php echo htmlspecialchars($juego['precio']); ?></td>
                    <td>
                        <form action="../Controlador/carrito_acciones.php?accion=actualizar&id=<?php echo $id; ?>" method="post" class="d-flex">
                            <input type="number" name="cantidad" value="<?php echo $juego['cantidad']; ?>" min="1" max="<?php echo $juego['stock']; ?>" class="form-control" style="width: 80px;">
                            <button type="submit" class="btn btn-secondary btn-sm ms-2">Actualizar</button>
                        </form>
                    </td>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                    <td>
                        <a href="../Controlador/carrito_acciones.php?accion=eliminar&id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="row justify-content-end">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total de la Compra</h5>
                    <p class="card-text fs-4"><strong>$<?php echo number_format($total, 2); ?></strong></p>
                    <a href="../Controlador/procesar_compra.php" class="btn btn-primary w-100">Procesar Compra</a>
                    <a href="catalogo.php" class="btn btn-outline-secondary w-100 mt-2">Seguir Comprando</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>
