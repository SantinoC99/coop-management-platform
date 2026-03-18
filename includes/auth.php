<?php
require_once __DIR__ . '/security.php';

/**
 * FUNCIONES DE AUTENTICACION Y PERMISOS DE ADMINISTRACION
 * Gestiona la sesion del administrador y protege el acceso al panel
 * Verifica si el usuario actual es administrador.
 * Si no lo es, redirige a la pagina de acceso
 */
function requerirAdmin(){

    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        header('Location: ' .obtenerRutaProyecto('public/iniciarSesion.php'));
        exit();
    }
}

function esAdmin(){
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}


?>
