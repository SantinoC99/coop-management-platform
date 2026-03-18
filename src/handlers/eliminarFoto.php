<?php

session_start();
require_once '../../includes/config.php';
require_once '../../includes/services/galeria.php';
require_once '../../includes/auth.php';
require_once '../../includes/security.php';

requerirAdmin();
exigirCsrf('../../src/admin/panel.php?error=sesion#galeria');

//Obtener y eliminar la foto
$index = isset($_POST['index']) ? (int) $_POST['index'] : -1;
eliminarFotoDeGaleria($index);

// Redirige al panel de administracion
header('Location: ../../src/admin/panel.php#galeria');
exit();
?>
