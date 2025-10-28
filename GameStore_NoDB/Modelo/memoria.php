<?php
// GameStore_NoDB/Modelo/memoria.php

class Memoria {
    public static function init() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['db'])) {
            $_SESSION['db'] = [
                'usuarios' => [],
                'juegos' => [],
                'transacciones' => [],
                'detalle_transacciones' => [],
                'next_user_id' => 1,
                'next_juego_id' => 1,
                'next_transaccion_id' => 1,
                'next_detalle_id' => 1,
            ];

            // Add default users
            self::addUser('Admin', 'admin@gamestore.com', 'admin', 'admin');
            $vendedor_id = self::addUser('Vendedor Uno', 'vendedor@gamestore.com', 'vendedor', 'vendedor');
            self::addUser('Cliente Uno', 'cliente@gamestore.com', 'cliente', 'cliente');

            // Add default games
            self::addJuego('The Witcher 3', 'RPG', 39.99, 50, $vendedor_id);
            self::addJuego('Cyberpunk 2077', 'RPG', 49.99, 30, $vendedor_id);
            self::addJuego('Red Dead Redemption 2', 'Action', 59.99, 40, $vendedor_id);
            self::addJuego('Hades', 'Roguelike', 24.99, 100, $vendedor_id);
        }
    }

    private static function addUser($nombre, $correo, $password, $rol) {
        $id = $_SESSION['db']['next_user_id']++;
        $_SESSION['db']['usuarios'][$id] = [
            'id_usuario' => $id,
            'nombre' => $nombre,
            'correo' => $correo,
            'contraseña' => password_hash($password, PASSWORD_DEFAULT),
            'rol' => $rol,
        ];
        return $id;
    }

    private static function addJuego($titulo, $genero, $precio, $stock, $vendedor_id) {
        $id = $_SESSION['db']['next_juego_id']++;
        $_SESSION['db']['juegos'][$id] = [
            'id_juego' => $id,
            'titulo' => $titulo,
            'genero' => $genero,
            'precio' => $precio,
            'stock' => $stock,
            'id_vendedor' => $vendedor_id,
        ];
        return $id;
    }
}

// Initialize the data store on first include
Memoria::init();
?>
