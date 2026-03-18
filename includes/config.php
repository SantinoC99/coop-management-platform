<?php
/**
 * CONFIGURACION CENTRAL DEL PROYECTO
 *centraliza todas las configuraciones globales del proyecto
 * incluyendo rutas de directorios, archivos de datos y limites de carga.
 */

//Directorios principales
define('BASE_DIR', __DIR__ . '/..');
define('UPLOADS_DIR',  BASE_DIR . '/public/uploads');
define('GALERIA_DIR',  UPLOADS_DIR . '/galeria/');
define('NOTICIAS_DIR', UPLOADS_DIR . '/noticias/');

// Archivos JSON de datos
define('JSON_GALERIA',  BASE_DIR . '/data/galeria.json');
define('JSON_NOTICIAS', BASE_DIR . '/data/noticias.json');


define('DB_HOST', 'localhost');
define('DB_NAME', 'proyecto_cooperadora');
define('DB_USER', 'root');
define('DB_PASS', '');
define('ADMIN_USERS_TABLE', 'usuarios_admin');


define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
define('ALLOWED_IMAGE_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

//Crear directorios si no existen (portabilidad)
if(!is_dir(GALERIA_DIR)){
    mkdir(GALERIA_DIR, 0777, true);
}if(!is_dir(NOTICIAS_DIR)){
    mkdir(NOTICIAS_DIR, 0777, true);
}
?>
