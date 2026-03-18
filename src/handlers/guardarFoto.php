<?php
/** 
 *Gestiona la adicion de una nueva foto a la galeria.
 *Valida la imagen
 *La guarda en el servidor
 *Agrega el registro a galeria.json
 *Redirige a la galeria
 */

session_start();
require_once '../../includes/auth.php';
require_once '../../includes/security.php';
require_once '../../includes/config.php';
require_once '../../includes/services/galeria.php';

requerirAdmin();
exigirCsrf('../../src/admin/agregarFoto.php?error=sesion');

// Validacion
if(isset($_FILES['imagen']) && $_FILES['imagen']['name']){
    $validacion = validarImagen($_FILES['imagen']);
    if(!$validacion['success']) {
        header('Location: ../../src/admin/agregarFoto.php?error=' . urlencode($validacion['error']));
        exit();
    }
    
    // Guarda la imagen en el servidor
    $guardado = guardarImagen($_FILES['imagen'], GALERIA_DIR);
    if ($guardado['success']){
        agregarFotoAGaleria($guardado['ruta'], $_POST['descripcion']);
        header('Location: ../../src/admin/panel.php#galeria');
        exit();
    }else{
        header('Location: ../../src/admin/agregarFoto.php?error=' . urlencode($guardado['error']));
        exit();
    }

} else{
    header('Location: ../../src/admin/agregarFoto.php?error=' . urlencode('Debe seleccionar una imagen.'));
    exit();
}
?>
