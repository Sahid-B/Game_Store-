<?php include 'header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <h2 class="text-center">Iniciar Sesión</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">Usuario o contraseña incorrectos.</div>
        <?php endif; ?>
        <?php if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso'): ?>
            <div class="alert alert-success">Registro exitoso. ¡Ya puedes iniciar sesión!</div>
        <?php endif; ?>
        <form action="../Controlador/login.php" method="POST">
            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
                <label for="contraseña" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Acceder</button>
        </form>
        <div class="text-center mt-3">
            <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
            <p><a href="index.php">Volver al inicio</a></p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
