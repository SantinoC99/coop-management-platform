<?php
/**
 *Gestiona la creacion de una nueva noticia.
 *obtiene los datos del formulario
 * guarda la imagen si se proporciono
 *Agrega la noticia al archivo JSON
 *Redirige a la pagina principal
 */

session_start();
require_once '../../includes/config.php';
require_once '../../includes/security.php';
require_once '../../includes/services/imagenes.php';
require_once '../../includes/services/noticias.php';
require_once '../../includes/auth.php';

requerirAdmin();
exigirCsrf('../../src/admin/crearNoticia.php?error=sesion');

// Obtiene datos del formulario
$titulo = trim((string) ($_POST['titulo'] ?? ''));
$subtitulo = trim((string) ($_POST['subtitulo'] ?? ''));
$descripcion = trim((string) ($_POST['descripcion'] ?? ''));
$detalles = trim((string) ($_POST['detalles'] ?? ''));

if($titulo === '' || $descripcion === ''){
    header('Location: ../../src/admin/crearNoticia.php?error=' . urlencode('Titulo y descripcion son obligatorios.'));
    exit();
}

if(strlen($titulo) > 120 || strlen($subtitulo) > 140 || strlen($descripcion) > 500 || strlen($detalles) > 5000) {
    header('Location: ../../src/admin/crearNoticia.php?error=' . urlencode('Uno o mas campos superan el largo permitido.'));
    exit();
}

// Procesa la imagen si se subio
$imagen = '';
if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK){
    $guardado = guardarArchivoImagen($_FILES['imagen'], NOTICIAS_DIR);
    if(!$guardado['success']){
        header('Location: ../../src/admin/crearNoticia.php?error=' . urlencode($guardado['error']));
        exit();
    }

    $imagen = $guardado['ruta'];
}elseif (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE){
    header('Location: ../../src/admin/crearNoticia.php?error=' . urlencode('La imagen no se pudo cargar correctamente.'));
    exit();
}

agregarNoticia($titulo, $descripcion, $imagen, $detalles, $subtitulo);


header('Location: ../../src/admin/panel.php#noticias');
exit();
?>
