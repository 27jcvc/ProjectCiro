<?php


// Leemos el archivo .env de forma nativa
$env = parse_ini_file(__DIR__ . '/.env');

// Definimos las constantes usando los valores leídos del .env
define('HOST', $env['HOST'] ?? 'localhost');
define('DBNAME', $env['DBNAME'] ?? '');
define('USER', $env['USER'] ?? 'root');
define('PASS', $env['PASS'] ?? '');
class Database {

    public static function getConnection(): PDO | null {

        try {
            // Construye la conexión MySQL mediante PDO con los datos configurados arriba.
            // Usamos las constantes
            $connexio = new PDO(
                "mysql:host=" . HOST . ";dbname=" . DBNAME . ";charset=utf8mb4", USER, PASS);

            // Entrega la conexión al código que necesite consultar la base de datos.
            return $connexio;

        } catch (PDOException $e) {
            // Muestra el motivo de fallo y comunica al llamador que no hay conexión disponible.
            echo "Error: " . $e -> getMessage();

            return null;
        }
    }

    // Crea y devuelve una conexión PDO; devuelve null si la conexión no puede establecerse.

    // Libera la referencia local a la conexión e informa si había una conexión que cerrar.
    public static function close($connexio): bool{

        // No hay nada que liberar si el intento de conexión devolvió null.
        if ($connexio === null) {
            return false;
        }

        // Al finalizar una petición web PHP también libera los recursos de la conexión.
        // Asignar null libera esta referencia; closeCursor() solo liberaría resultados de una sentencia.
        $connexio = null;

        return true;
    }


        // Ejecuta el script SQL de inicialización si está presente en el directorio del controlador.
    public static function inicialize(): void{
        

        try {
            // Abre la conexión y localiza el archivo SQL relativo a este archivo PHP.
            // Usamos las constantes
            $connexio = new PDO("mysql:host=" . HOST . ";charset=utf8mb4", USER, PASS);
            $sqlPath = __DIR__ . '/pt04_julio_vazquez.sql';

            // Lee y ejecuta el script para crear la estructura y cargar los datos iniciales.
            if (file_exists($sqlPath)) {
                $sql = file_get_contents($sqlPath);
                $connexio->exec($sql);
            }

            // Libera la conexión después de la inicialización.
            Database::close($connexio);
            
        } catch (PDOException $e) {
            // Informa de errores PDO durante la ejecución del script de inicialización.
            echo "Error: " . $e -> getMessage();
        }
    }    
}