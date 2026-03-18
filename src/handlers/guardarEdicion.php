<?php

session_start();
require_once '../../includes/config.php';
require_once '../../includes/security.php';
require_once '../../includes/services/imagenes.php';
require_once '../../includes/services/noticias.php';
require_once '../../includes/auth.php';

$indexRedireccion = isset($_POST['index']) ? (int) $_POST['index'] : -1;

requerirAdmin();
exigirCsrf('../../src/admin/editarNoticia.php?index=' . $indexRedireccion . '&error=sesion');

// Obtiene datos del formulario
$index = isset($_POST['index']) ? (int)$_POST['index'] : -1;
$noticias = leerNoticias();

// Valida que la noticia existe
if($index >= 0 && $index < count($noticias)){
    $titulo = trim((string) ($_POST['titulo'] ?? ''));
    $subtitulo = trim((string) ($_POST['subtitulo'] ?? ''));
    $descripcion = trim((string) ($_POST['descripcion'] ?? ''));
    $detalles = trim((string) ($_POST['detalles'] ?? ''));
    $imagen = $noticias[$index]['imagen'] ?? '';

    if($titulo === '' || $descripcion === ''){
        header('Location: ../../src/admin/editarNoticia.php?index=' .$index. '&error=' . urlencode('Titulo y descripcion son obligatorios.'));
        exit();
    }

    if(strlen($titulo) > 120 || strlen($subtitulo) > 140 || strlen($descripcion) > 500 || strlen($detalles) > 5000){
        header('Location: ../../src/admin/editarNoticia.php?index=' .$index. '&error=' . urlencode('Uno o mas campos superan el largo permitido.'));
        exit();
    }

    // Procesa la nueva imagen si se subio
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK){
        $guardado = guardarArchivoImagen($_FILES['imagen'], NOTICIAS_DIR);

        if(!$guardado['success']){
            header('Location: ../../src/admin/editarNoticia.php?index=' .$index. '&error=' . urlencode($guardado['error']));
            exit();
        }

        if($imagen !== ''){
            $rutaAnterior = BASE_DIR . '/' . $imagen;
            if(file_exists($rutaAnterior)){
                unlink($rutaAnterior);
            }
        }

        $imagen = $guardado['ruta'];

    }elseif(isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE){

        header('Location: ../../src/admin/editarNoticia.php?index=' .$index. '&error=' . urlencode('La imagen no se pudo cargar correctamente.'));
        exit();
    }

    // Procesa la eliminacion de imagen si se marco la opcion
    if(isset($_POST['eliminar_imagen']) && $_POST['eliminar_imagen'] == 'on'){
        $rutaActual= BASE_DIR . '/' . $noticias[$index]['imagen'];
        if($noticias[$index]['imagen'] && file_exists($rutaActual)){
            unlink($rutaActual);
        }
        $imagen = '';
    }

    // Actualiza la noticia
    $noticias[$index]['titulo']= $titulo;
    $noticias[$index]['subtitulo']= $subtitulo;
    $noticias[$index]['descripcion']= $descripcion;
    $noticias[$index]['detalles']= $detalles;
    $noticias[$index]['imagen']= $imagen;

    guardarNoticias($noticias);
}


header('Location: ../../src/admin/panel.php#noticias');
exit();
?>
