<?php
class Database {
    // Lee las credenciales de las variables de entorno para mayor seguridad
    // Asegúrate de configurar estas variables en tu servidor (ej. en un archivo .env o en la configuración de Apache/Nginx)
    private $serverName = getenv('DB_SERVER') ?: 'localhost'; // Servidor por defecto: localhost
    private $dbName = getenv('DB_NAME') ?: 'GameStore';     // Nombre de la BD por defecto
    private $uid = getenv('DB_USER') ?: 'your_username';       // Usuario
    private $pwd = getenv('DB_PASS') ?: 'your_password';       // Contraseña

    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $dsn = "sqlsrv:server={$this->serverName};database={$this->dbName}";
            $this->conn = new PDO($dsn, $this->uid, $this->pwd);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // En un entorno de producción, nunca muestres errores detallados.
            // Regístralos en un archivo de log.
            error_log("Error de conexión a la base de datos: " . $e->getMessage());
            // Muestra un mensaje genérico al usuario
            die("Error: No se pudo conectar a la base de datos. Por favor, inténtelo más tarde.");
        }
        return $this->conn;
    }
}
?>
