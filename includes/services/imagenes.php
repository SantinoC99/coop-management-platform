<?php
require_once __DIR__ . '/../config.php';

function validarArchivoImagen($archivo){

    if(!isset($archivo['name'], $archivo['tmp_name'], $archivo['size'], $archivo['error'])){

        return ['success' => false, 'error' => 'No se recibio una imagen valida.'];
    }

    if($archivo['error'] !== UPLOAD_ERR_OK){
        return ['success' => false, 'error' => ' La imagen no se pudo cargar correctamente.'];
    }

    if($archivo['size'] > MAX_FILE_SIZE){
        return ['success' => false, 'error' => 'La imagen supera el tamano permitido.'];
    }

    $extension = strtolower((string) pathinfo($archivo['name'], PATHINFO_EXTENSION));

    if(!in_array($extension, ALLOWED_IMAGE_EXTENSIONS, true)){
        return ['success' => false, 'error' => 'La extension del archivo no esta permitida.'];
    }

    $finfo= new finfo(FILEINFO_MIME_TYPE);
    $mimeType= $finfo -> file($archivo['tmp_name']);

    if($mimeType === false || !in_array($mimeType, ALLOWED_IMAGE_TYPES, true)){
        return ['success' => false, 'error' => 'El archivo no es una imagen permitida.'];
    }

    return[
        'success' => true,
        'extension' => $extension,
        'mime_type' => $mimeType,
    ];
}

function normalizarNombreImagen($nombreOriginal){
    $nombreBase = strtolower((string) pathinfo($nombreOriginal, PATHINFO_FILENAME));
    $nombreBase = preg_replace('/[^a-z0-9_-]+/i', '-', $nombreBase);
    $nombreBase = trim((string) $nombreBase, '-_');

    return $nombreBase !== '' ? $nombreBase: 'imagen';
}

function guardarArchivoImagen($archivo, $directorio){
    $validacion = validarArchivoImagen($archivo);
    if(!$validacion['success']) {
        return $validacion;
    }

    if(!is_dir($directorio)){
        mkdir($directorio, 0777, true);
    }

    $prefijo= str_replace('.', '', uniqid('', true));
    $nombreArchivo = $prefijo . '_' . normalizarNombreImagen($archivo['name']) . '.' .$validacion['extension'];
    $rutaAbsoluta = rtrim($directorio, '\\/') . DIRECTORY_SEPARATOR .$nombreArchivo;

    if(!move_uploaded_file($archivo['tmp_name'], $rutaAbsoluta)){
        return ['success' => false, 'error' => 'No se pudo guardar la imagen en el servidor.'];
    }

    $base= rtrim(str_replace('\\', '/', realpath(BASE_DIR)), '/') . '/';
    $ruta= str_replace($base, '', str_replace('\\', '/', realpath($rutaAbsoluta)));

    return ['success' => true, 'ruta' => $ruta];
}
?>