<?php
session_start();
require_once __DIR__ . '/../../includes/security.php';
$_SESSION = [];

session_destroy();
header('Location: ' . obtenerRutaProyecto('public/'));

exit();
?>
