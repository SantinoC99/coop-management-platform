<?php
require_once __DIR__ . '/../config.php';

// Estandariza cada noticia para evitar estructuras inconsistentes

function normalizarNoticia($noticia){
    if(!is_array($noticia)){
        return null;
    }
    return[
        'titulo' => (string) ($noticia['titulo'] ?? 'Sin titulo'),
        'subtitulo' => (string) ($noticia['subtitulo'] ?? ''),
        'descripcion' => (string) ($noticia['descripcion'] ?? ''),
        'detalles' => (string) ($noticia['detalles'] ?? ''),
        'imagen' => (string) ($noticia['imagen'] ?? ''),
        'fecha' => (string) ($noticia['fecha'] ?? '2024-01-01 00:00:00'),
    ];
}

// Transforma la fecha de una noticia en timestamp para poder ordenar
function obtenerTimestampNoticia($noticia){
    $timestamp = strtotime($noticia['fecha'] ?? '');
    return $timestamp !== false ? $timestamp : 0;
}

// Carga noticias desde JSON, normaliza y ordena de mas nueva a mas vieja
function leerNoticias() {
    if(!file_exists(JSON_NOTICIAS)) {
        return [];
    }

    $contenido = file_get_contents(JSON_NOTICIAS);
    if($contenido === false || trim($contenido) === '') {
            return [];
    }

    $contenido = preg_replace('/^\xEF\xBB\xBF/', '', $contenido);

    $noticias = json_decode($contenido, true);
    if(!is_array($noticias)){
        return [];
    }

    $noticias = array_values(array_filter(array_map('normalizarNoticia', $noticias)));

    // orden descendente por fecha para mostrar primero lo reciente.
    usort($noticias, function($a, $b){
        return obtenerTimestampNoticia($b) <=> obtenerTimestampNoticia($a);
    });

    return $noticias;
}

// mejora lectura del archivo
function guardarNoticias($noticias){
    $noticias = array_values(array_filter(array_map('normalizarNoticia', $noticias)));
    file_put_contents(
        JSON_NOTICIAS,
        json_encode($noticias, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
    );
}

function agregarNoticia($titulo, $descripcion, $imagen = null, $detalles = '', $subtitulo = '', $fecha = null){
    $noticias   = leerNoticias();
    $noticias[] = [
        'titulo'      => $titulo,
        'subtitulo'   => $subtitulo,
        'descripcion' => $descripcion,
        'imagen'      => $imagen,
        'detalles'    => $detalles,
        'fecha'       => $fecha ?: date('Y-m-d H:i:s')
    ];
    guardarNoticias($noticias);
}


function eliminarNoticia($indice){
    $noticias = leerNoticias();
    if(isset($noticias[$indice])){

        $imagen = $noticias[$indice]['imagen'];
        $rutaAbsoluta = BASE_DIR . '/' . $imagen;
        if($imagen && file_exists($rutaAbsoluta)){
            unlink($rutaAbsoluta);
        }
        unset($noticias[$indice]);
        guardarNoticias(array_values($noticias));
        return true;
    }
    return false;
}

function actualizarNoticia($indice, $titulo, $descripcion, $imagen = null, $detalles = '', $subtitulo = ''){
    $noticias = leerNoticias();
    if(isset($noticias[$indice])){
        $noticias[$indice]['titulo'] = $titulo;
        $noticias[$indice]['subtitulo'] = $subtitulo;
        $noticias[$indice]['descripcion'] = $descripcion;
        $noticias[$indice]['detalles'] = $detalles;

        if($imagen){
            $noticias[$indice]['imagen'] = $imagen;
        }
        guardarNoticias($noticias);
        return true;
    }
    return false;
}


?>
