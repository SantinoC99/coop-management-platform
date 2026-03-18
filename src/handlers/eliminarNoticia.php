<?php

session_start();
require_once '../../includes/config.php';
require_once '../../includes/services/noticias.php';
require_once '../../includes/auth.php';
require_once '../../includes/security.php';

requerirAdmin();
exigirCsrf('../../src/admin/panel.php?error=sesion#noticias');

// obtiene y elimina la noticia
$index = isset($_POST['index']) ? (int) $_POST['index'] : -1;
eliminarNoticia($index);

// Redirige al panel de administracion
header('Location: ../../src/admin/panel.php#noticias');
exit();
?>
