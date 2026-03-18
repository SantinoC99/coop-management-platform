<?php
/**
 * DETALLE DE NOTICIA
 *
 * Pagina que muestra el contenido completo de una noticia especifica.
 * Se accede mediante el indice de la noticia en la URL.
 */

session_start();
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/security.php';
require_once __DIR__ . '/../../includes/services/noticias.php';

function escapar($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

// Obtener el indice de la noticia desde la URL.
$indice = isset($_GET['index']) ? (int) $_GET['index'] : -1;
$noticias = leerNoticias();

if ($indice < 0 || $indice >= count($noticias)) {
    echo "Noticia no encontrada";
    exit();
}

$noticia = $noticias[$indice];
$urlInicio = escapar(obtenerRutaProyecto('public/'));
$urlGaleria = escapar(obtenerRutaProyecto('public/galeria.php'));
$urlDonar = escapar(obtenerRutaProyecto('public/donar.php'));

$titulo = escapar($noticia['titulo'] ?? 'Sin título');
$subtitulo = escapar($noticia['subtitulo'] ?? '');
$descripcion = escapar($noticia['descripcion'] ?? '');

$urlImagen = '';
if (!empty($noticia['imagen'])) {
    $rutaRelativa = ltrim((string) $noticia['imagen'], '/');
    $urlImagen = escapar(obtenerRutaProyecto($rutaRelativa));
}

$detalleHtml = 'No hay detalles adicionales para esta noticia.';
if (!empty($noticia['detalles'])) {
    $detalleHtml = nl2br(escapar($noticia['detalles']));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --fondo-suave: #fcefef;
            --superficie: #f8eeeb;
            --borde-suave: #d8e1e8;
            --texto-principal: #060707;
            --texto-secundario: #5d6f80;
            --acento: #000000;
            --acento-oscuro: #af0000;
            --portada-a: #be0f0f;
            --portada-b: #b8d6ee;
        }

        html, body {
            min-height: 100%;
            margin: 0;
            background:
                radial-gradient(circle at top right, rgba(255, 139, 123, 0.33), transparent 24%),
                linear-gradient(180deg, #f8fbfd 0%, var(--fondo-suave) 100%);
            color: var(--texto-principal);
        }

        .barra-superior {
            backdrop-filter: blur(10px);
            background: rgba(248, 251, 253, 0.88);
            border-bottom: 1px solid rgba(216, 225, 232, 0.95);
        }

        .contenedor-articulo {
            max-width: 980px;
        }

        .portada-articulo {
            background: linear-gradient(135deg, var(--portada-a) 0%, var(--portada-b) 100%);
            color: #fff;
            border-radius: 28px;
            padding: 2.2rem;
            box-shadow: 0 24px 48px rgba(16, 32, 48, 0.18);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .portada-articulo::after {
            content: '';
            position: absolute;
            width: 240px;
            height: 240px;
            right: -80px;
            top: -70px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.10);
        }

        .portada-articulo > * {
            position: relative;
            z-index: 1;
        }

        .subtitulo-articulo {
            color: rgba(255, 255, 255, 0.82);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 0.85rem;
        }

        .tarjeta-articulo {
            border: 1px solid var(--borde-suave);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 18px 36px rgba(16, 32, 48, 0.10);
            background: var(--superficie);
        }

        .imagen-articulo {
            width: 100%;
            max-height: 520px;
            object-fit: cover;
            display: block;
        }

        .cuerpo-articulo {
            background: var(--superficie);
            padding: 2rem;
        }

        .texto-articulo {
            font-size: 1.15rem;
            line-height: 1.8;
            color: var(--texto-secundario);
            margin-bottom: 0;
        }

        @media (max-width: 767px) {
            .portada-articulo {
                border-radius: 22px;
                padding: 1.5rem;
            }

            .barra-superior .container > .d-flex {
                justify-content: center;
            }

            .barra-superior .navbar-brand {
                width: 100%;
                justify-content: center;
                text-align: center;
            }

            .barra-superior .container > .d-flex > .d-flex {
                width: 100%;
                justify-content: center;
            }

            .cuerpo-articulo {
                padding: 1.35rem;
            }

            .texto-articulo {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

<!-- Encabezado -->
<header class="barra-superior py-3">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <a class="navbar-brand d-inline-flex align-items-center gap-2" href="<?php echo $urlInicio; ?>">
                <img src="<?php echo escapar(obtenerRutaProyecto('img/LogoChaca.png')); ?>" alt="Logo del colegio" style="height:56px; width:auto;">
                <h1 class="m-0">Cooperadora Escolar</h1>
            </a>
            <div class="d-flex gap-2 flex-wrap">
                <a href="<?php echo $urlInicio; ?>" class="btn btn-outline-dark d-inline-flex align-items-center gap-2">
                    <span>Volver</span>
                </a>
                <a href="<?php echo $urlGaleria; ?>" class="btn btn-outline-dark d-inline-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M15 8h.01"/><path d="M3 6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3z"/><path d="m3 16l5-5c.928-.893 2.072-.893 3 0l5 5"/><path d="m14 14l1-1c.928-.893 2.072-.893 3 0l3 3"/></g></svg>
                    <span>Galería</span>
                </a>
                <a href="<?php echo $urlDonar; ?>" class="btn btn-outline-dark d-inline-flex align-items-center gap-2" title="Ir a donaciones">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="1.5"><path d="M16 6.28a2.28 2.28 0 0 1-.662 1.606c-.976.984-1.923 2.01-2.936 2.958a.597.597 0 0 1-.822-.017l-2.918-2.94a2.28 2.28 0 0 1 0-3.214a2.277 2.277 0 0 1 3.232 0L12 4.78l.106-.107A2.276 2.276 0 0 1 16 6.28Z"/><path stroke-linecap="round" d="m18 20l3.824-3.824a.6.6 0 0 0 .176-.424V10.5A1.5 1.5 0 0 0 20.5 9v0a1.5 1.5 0 0 0-1.5 1.5V15"/><path stroke-linecap="round" d="m18 16l.858-.858a.48.48 0 0 0 .142-.343v0a.49.49 0 0 0-.268-.433l-.443-.221a2 2 0 0 0-2.308.374l-.895.895a2 2 0 0 0-.586 1.414V20M6 20l-3.824-3.824A.6.6 0 0 1 2 15.752V10.5A1.5 1.5 0 0 1 3.5 9v0A1.5 1.5 0 0 1 5 10.5V15"/><path stroke-linecap="round" d="m6 16l-.858-.858A.5.5 0 0 1 5 14.799v0c0-.183.104-.35.268-.433l.443-.221a2 2 0 0 1 2.308.374l.895.895a2 2 0 0 1 .586 1.414V20"/></g></svg>
                    <span>Donar</span>
                </a>
            </div>
        </div>
    </div>
</header>
<!-- Fin de encabezado -->

<main class="container my-4 my-lg-5 contenedor-articulo">
    <section class="portada-articulo">
        <?php if ($subtitulo !== ''): ?>
            <p class="subtitulo-articulo"><?php echo $subtitulo; ?></p>
        <?php endif; ?>
        <h1 class="display-5 mb-3"><?php echo $titulo; ?></h1>
        <p class="mb-0 fs-5"><?php echo $descripcion; ?></p>
    </section>

    <article class="tarjeta-articulo">
        <?php if ($urlImagen !== ''): ?>
            <img src="<?php echo $urlImagen; ?>" class="imagen-articulo" alt="Imagen de la noticia" onerror="this.style.display='none';">
        <?php endif; ?>
        <div class="cuerpo-articulo">
            <p class="texto-articulo"><?php echo $detalleHtml; ?></p>
        </div>
    </article>
</main>

<!-- Pie de pagina -->
<footer class="bg-dark text-white text-center py-4">
    <div class="container">
        <h5>Seguinos en Instagram</h5>
        <div class="social-icons">
            <a href="https://www.instagram.com/tecnica6moron_oficial/?hl=es" class="text-white mx-2" title="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
        <hr class="my-4" />
        <p>Contacto: <a href="mailto:example123@gmail.com" class="text-white">example123@gmail.com</a></p>
        <p>&copy; 2024 Cooperadora Escolar. Todos los derechos reservados.</p>
    </div>
</footer>

</body>
</html>
