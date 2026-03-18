<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/imagenes.php';

//Valida que una imagen cumpla con los requisitos
function validarImagen($archivo){
    return validarArchivoImagen($archivo);
}

//Guarda una imagen y devuelve su ruta web-relativa desde la raiz del proyecto
function guardarImagen($archivo, $directorio){
    return guardarArchivoImagen($archivo, $directorio);
}

function leerGaleria(){
    if(!file_exists(JSON_GALERIA)){
        return [];
    }

    $contenido = file_get_contents(JSON_GALERIA);
    if($contenido === false || trim($contenido) === ''){
        return [];
    }

    $contenido = preg_replace('/^\xEF\xBB\xBF/', '', $contenido);
    $galeria = json_decode($contenido, true);

    return is_array($galeria) ? $galeria : [];
}

function guardarGaleria($galeria){
    file_put_contents(JSON_GALERIA, json_encode($galeria, JSON_PRETTY_PRINT));
}

function agregarFotoAGaleria($ruta, $descripcion){
    $galeria = leerGaleria();
    $galeria[] = ['imagen' => $ruta, 'descripcion' => $descripcion];

    guardarGaleria($galeria);
}

function eliminarFotoDeGaleria($indice){
    $galeria = leerGaleria();

    if(isset($galeria[$indice])){
        $imagen = $galeria[$indice]['imagen'];
        $rutaAbsoluta = BASE_DIR . '/' . $imagen;

        if($imagen && file_exists($rutaAbsoluta)){
            unlink($rutaAbsoluta);
        }
        unset($galeria[$indice]);

        guardarGaleria(array_values($galeria));
        return true;
    }
    return false;
}
?>
