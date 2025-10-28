<?php include 'header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="text-center">Registro de Usuario</h2>
        <form action="../Controlador/registro.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
                <label for="contraseña" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña" required>
            </div>
            <div class="mb-3">
                <label for="rol" class="form-label">Registrarse como</label>
                <select class="form-select" id="rol" name="rol" required>
                    <option value="cliente">Cliente</option>
                    <option value="vendedor">Vendedor</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrar</button>
        </form>
        <div class="text-center mt-3">
            <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
