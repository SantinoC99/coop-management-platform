<?php
/*
 Aplicaciones de seguridad compartidas:
  -Calcula rutas del proyecto en distintos entornos
  -Maneja token CSRF para formularios POST
*/

function obtenerBaseProyecto(){
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $segmentos = explode('/', trim($scriptName, '/'));

    return isset($segmentos[0]) && $segmentos[0] !== '' ? '/' . $segmentos[0]: '';
}


//Devuelve una ruta absoluta dentro del proyecto a partir de una ruta relativa
function obtenerRutaProyecto($rutaRelativa = ''){
    $rutaRelativa= ltrim((string) $rutaRelativa, '/');
    $baseProyecto= obtenerBaseProyecto();

    if($rutaRelativa === ''){
        return $baseProyecto !== '' ? $baseProyecto: '/';
    }

    return($baseProyecto !== '' ? $baseProyecto: '') . '/' .$rutaRelativa;
}


//Obtiene o crea el token CSRF de la sesion
function obtenerCsrfToken(){
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }

    if(empty($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])){
        try{
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }catch(Exception $exception){
            // alternatica por compatibilidad si random_bytes no esta disponible
            $_SESSION['csrf_token'] = hash('sha256', uniqid((string) mt_rand(), true));
        }
    }

    return $_SESSION['csrf_token'];
}


//Genera el input hidden con el token CSRF
function campoCsrf(){
    $token = htmlspecialchars(obtenerCsrfToken(), ENT_QUOTES, 'UTF-8');
    return '<input type="hidden" name="csrf_token" value="' .$token. '">';
}

//Valida el token recibido por formulario
function csrfValido($token){

$tokenSesion = $_SESSION['csrf_token'] ?? '';
    return is_string($tokenSesion) && is_string($token) && $token !== '' && hash_equals($tokenSesion, $token);
}

//Corta la ejecucion si la solicitud POST no tiene un token valido
function exigirCsrf($rutaRedireccion){
    if(($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST' || !csrfValido($_POST['csrf_token'] ?? null)){
     header('Location: ' .$rutaRedireccion);
        exit();
    }
}

?>