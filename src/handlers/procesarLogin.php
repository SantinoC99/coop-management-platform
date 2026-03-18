<?php
/**
 * PROCESAR ACCESO
 *Valida credenciales de administrador
 *Establece la sesion con rol admin
 *Redirige al panel de administracion si es exitoso
 *Redirige a pagina de error si falla
 */

session_start();

require_once '../../includes/security.php';
require_once '../../includes/services/admin_auth.php';

exigirCsrf('../../public/iniciarSesion.php?error=sesion');

$usuario = trim((string) ($_POST['usuario'] ?? $_POST['username'] ?? ''));
$clave = (string) ($_POST['clave'] ?? $_POST['password'] ?? '');

if($usuario === '' || $clave === ''){
    header('Location: ../../public/iniciarSesion.php?error=credenciales');
    exit();
}

$resultado = autenticarAdmin($usuario, $clave);

if($resultado['success']){
    $_SESSION['role'] = 'admin';
    $_SESSION['admin_id'] = $resultado['admin']['id'];
    $_SESSION['admin_usuario'] = $resultado['admin']['usuario'];
    $_SESSION['admin_username'] = $resultado['admin']['usuario'];
    header('Location: ../../src/admin/panel.php');
    exit();
}

header('Location: ../../public/iniciarSesion.php?error=' .urlencode($resultado['error']));
exit();
?>
