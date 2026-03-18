<?php
/**
 *gestiona la actualizacion de una foto en la galeria.
 *Obtiene el indice y los datos del formulario
 *Maneja la subida de nueva imagen si se proporciono
 *Actualiza el registro en el JSON
 *Redirige a la galeria
 */

session_start();
require_once '../../includes/config.php';
require_once '../../includes/services/galeria.php';
require_once '../../includes/auth.php';

$indexRedireccion = isset($_POST['index']) ? (int) $_POST['index'] : -1;
require_once '../../includes/security.php';


requerirAdmin();
exigirCsrf('../../src/admin/editarFoto.php?index=' . $indexRedireccion . '&error=sesion');

$index = isset($_POST['index']) ? (int)$_POST['index'] : -1;
$galeria = leerGaleria();


if($index >= 0 && $index < count($galeria)){
    
    $galeria[$index]['descripcion'] = $_POST['descripcion'];

    // Procesa nueva imagen si se proporciono
    if(isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['name']){
        $validacion = validarImagen($_FILES['nueva_imagen']);
        if(!$validacion['success']){
            header('Location: ../../src/admin/editarFoto.php?index=' . $index . '&error=' . urlencode($validacion['error']));
            exit();
        }

        $guardado = guardarImagen($_FILES['nueva_imagen'], GALERIA_DIR);
        if(!$guardado['success']){
            header('Location: ../../src/admin/editarFoto.php?index=' . $index . '&error=' . urlencode($guardado['error']));
            exit();
        }

        $imagenAnterior = $galeria[$index]['imagen'] ?? '';
        if($imagenAnterior !== ''){
            $rutaAnterior = BASE_DIR . '/' . $imagenAnterior;
            if(file_exists($rutaAnterior)) {
                unlink($rutaAnterior);
            }
        }

        $galeria[$index]['imagen'] = $guardado['ruta'];
    }

   
    guardarGaleria($galeria);
}


header('Location: ../../src/admin/panel.php#galeria');
exit();
?>
