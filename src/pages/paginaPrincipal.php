<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/security.php';
require_once __DIR__ . '/../../includes/services/noticias.php';

//Escapa texto para imprimirlo de forma segura en HTML
function escapar($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

// Lee las noticias desde JSON
$noticias = leerNoticias();
$urlInicio = escapar(obtenerRutaProyecto('public/'));
$urlGaleria = escapar(obtenerRutaProyecto('public/galeria.php'));
$urlDonar = escapar(obtenerRutaProyecto('public/donar.php'));
$urlAdmin = escapar(obtenerRutaProyecto('public/iniciarSesion.php'));
$urlDetalle = escapar(obtenerRutaProyecto('public/detalleNoticia.php'));
$cantidadNoticias = count($noticias);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias y Eventos</title>
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
            --portada-b: #d2ebff;
        }

        html, body {
            min-height: 100%;
            margin: 0;
            background:
                radial-gradient(circle at top right, rgba(255, 139, 123, 0.33), transparent 24%),
                linear-gradient(180deg, #f8fbfd 0%, var(--fondo-suave) 100%);
            color: var(--texto-principal);
        }

        .barra-superior{
            backdrop-filter: blur(10px);
            background: rgba(248, 251, 253, 0.88);
            border-bottom: 1px solid rgba(216, 225, 232, 0.95);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .marca-seccion{
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-size: 0.8rem;
            color: var(--acento);
            margin-bottom: 0.45rem;
        }

        .portada{
            background: linear-gradient(135deg, var(--portada-a) 0%, var(--portada-b) 100%);
            border-radius: 28px;
            padding: 2.5rem;
            color: #ffffff;
            box-shadow: 0 24px 48px rgba(16, 32, 48, 0.18);
            overflow: hidden;
            position: relative;
        }

        .portada::after{
            content: '';
            position: absolute;
            width: 240px;
            height: 240px;
            right: -80px;
            top: -70px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.10);
        }

        .portada p,
        .portada a{
            position: relative;
            z-index: 1;
        }

        .resumen-portada{
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            border-radius: 999px;
            padding: 0.55rem 0.9rem;
            background: rgba(255, 255, 255, 0.12);
            font-size: 0.95rem;
        }

        .encabezado-seccion{
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 1;
        }

        .tarjeta-noticia {
            height: 100%;
            border: 1px solid var(--borde-suave);
            border-radius: 24px;
            overflow: hidden;
            background: var(--superficie);
            box-shadow: 0 25px 32px rgba(16, 32, 48, 0.08);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .tarjeta-noticia:hover{
            transform: translateY(-6px); 
            box-shadow: 0 24px 40px rgba(16, 32, 48, 0.12);
        }

        .enlace-noticia{
            color: inherit;
            text-decoration:none;
            display: block;
            height: 100%;
        }

        .imagen-noticia{
            width: 100%;
            height: 240px;
            object-fit: cover;
            display: block;
        }

        .sin-imagen-noticia {
            height: 240px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #d7e1eb 0%, #bccbda 100%);
            color: #fff;
        }

        .cuerpo-noticia {
            padding: 1.35rem;
        }

        .subtitulo-noticia{
            color: var(--acento-oscuro);
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 0.8rem;
        }

        .titulo-noticia{
            font-size: 1.35rem;
            line-height: 1.2;
            margin-bottom: 0.75rem;
        }

        .texto-noticia {
            color: var(--texto-secundario);
            margin-bottom: 0;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .grilla-noticias > div {
            display: flex;
        }

        footer{
            margin-top: 4rem;
        }

        @media (max-width: 991px) {
            .portada {
                padding: 2rem;
            }

            .imagen-noticia,
            .sin-imagen-noticia {
                height: 220px;
            }
        }

        @media (max-width: 767px) {
            .portada {
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

            .encabezado-seccion {
                align-items: start;
                flex-direction: column;
            }

            .imagen-noticia,
            .sin-imagen-noticia {
                height: 200px;
            }
        }

        @media (max-width: 575px) {
            .resumen-portada {
                width: 100%;
                justify-content: center;
            }

            .titulo-noticia {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>


<header class="barra-superior py-3">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <a class="navbar-brand d-inline-flex align-items-center gap-2" href="<?php echo $urlInicio; ?>">
                <img src="<?php echo escapar(obtenerRutaProyecto('img/LogoChaca.png')); ?>" alt="Logo del colegio" style="height:56px; width:auto;">
                <h1 class="m-0">Cooperadora Escolar</h1>
            </a>
            <div class="d-flex gap-2 flex-wrap">
                <a href="<?php echo $urlGaleria; ?>" class="btn btn-outline-dark d-inline-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M15 8h.01"/><path d="M3 6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3z"/><path d="m3 16l5-5c.928-.893 2.072-.893 3 0l5 5"/><path d="m14 14l1-1c.928-.893 2.072-.893 3 0l3 3"/></g></svg>
                    <span>Galería</span>
                </a>
                <a href="<?php echo $urlDonar; ?>" class="btn btn-outline-dark d-inline-flex align-items-center gap-2" title="Ir a donaciones">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="1.5"><path d="M16 6.28a2.28 2.28 0 0 1-.662 1.606c-.976.984-1.923 2.01-2.936 2.958a.597.597 0 0 1-.822-.017l-2.918-2.94a2.28 2.28 0 0 1 0-3.214a2.277 2.277 0 0 1 3.232 0L12 4.78l.106-.107A2.276 2.276 0 0 1 16 6.28Z"/><path stroke-linecap="round" d="m18 20l3.824-3.824a.6.6 0 0 0 .176-.424V10.5A1.5 1.5 0 0 0 20.5 9v0a1.5 1.5 0 0 0-1.5 1.5V15"/><path stroke-linecap="round" d="m18 16l.858-.858a.48.48 0 0 0 .142-.343v0a.49.49 0 0 0-.268-.433l-.443-.221a2 2 0 0 0-2.308.374l-.895.895a2 2 0 0 0-.586 1.414V20M6 20l-3.824-3.824A.6.6 0 0 1 2 15.752V10.5A1.5 1.5 0 0 1 3.5 9v0A1.5 1.5 0 0 1 5 10.5V15"/><path stroke-linecap="round" d="m6 16l-.858-.858A.5.5 0 0 1 5 14.799v0c0-.183.104-.35.268-.433l.443-.221a2 2 0 0 1 2.308.374l.895.895a2 2 0 0 1 .586 1.414V20"/></g></svg>
                    <span>Donar</span>
                </a>
                <a href="<?php echo $urlAdmin; ?>" class="btn btn-outline-dark d-inline-flex align-items-center gap-2" title="Acceso al panel de administración">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5zm9 12h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-8v2h8z"/></svg>
                    <span>Administración</span>
                </a>
            </div>
        </div>
    </div>
</header>
<!-- Fin de encabezado -->

<main class="container py-4 py-lg-5">
    <section class="portada mb-4 mb-lg-5">
        <p class="marca-seccion">Comunidad educativa</p>
        <h1 class="display-5 mb-3">Noticias y eventos de la cooperadora</h1>
        <p class="lead mb-4">Conoce las mejoras, actividades y proyectos que impactan directamente en la vida escolar. Las publicaciones más recientes aparecen primero para destacar lo último que sucede en la comunidad.</p>
        <div class="resumen-portada">
            <i class="fas fa-calendar-alt"></i>
            <span><?php echo $cantidadNoticias; ?> publicaciones activas</span>
        </div>
    </section>

    <section>
        <div class="encabezado-seccion mb-4">
            <div>
                <p class="text-uppercase text-muted mb-1">Actualidad</p>
                <h2 class="h3 mb-0">Novedades recientes</h2>
            </div>
        </div>
    <?php if (empty($noticias)): ?>
        <div class="alert alert-secondary text-center">Todavía no hay noticias publicadas.</div>
    <?php else: ?>
        <div class="row g-4 grilla-noticias">
            <?php foreach ($noticias as $indice => $noticia): ?>
                <?php
                $titulo = escapar($noticia['titulo'] ?? 'Sin título');
                $subtitulo = escapar($noticia['subtitulo'] ?? '');
                $descripcion = escapar($noticia['descripcion'] ?? '');

                $urlImagen = '';
                if (!empty($noticia['imagen'])) {
                    $rutaRelativa = ltrim((string) $noticia['imagen'], '/');
                    $urlImagen = escapar(obtenerRutaProyecto($rutaRelativa));
                }
                ?>
                <div class="col-sm-6 col-xl-4">
                    <article class="tarjeta-noticia">
                        <a href="<?php echo $urlDetalle; ?>?index=<?php echo (int) $indice; ?>" class="enlace-noticia">
                            <?php if ($urlImagen !== ''): ?>
                                <img src="<?php echo $urlImagen; ?>" class="imagen-noticia" alt="<?php echo $titulo; ?>" onerror="this.style.display='none';">
                            <?php else: ?>
                                <div class="sin-imagen-noticia">
                                    <i class="fas fa-image fa-3x text-white"></i>
                                </div>
                            <?php endif; ?>
                            <div class="cuerpo-noticia">
                                <?php if ($subtitulo !== ''): ?>
                                    <p class="subtitulo-noticia"><?php echo $subtitulo; ?></p>
                                <?php endif; ?>
                                <h3 class="titulo-noticia"><?php echo $titulo; ?></h3>
                                <p class="texto-noticia"><?php echo $descripcion; ?></p>
                            </div>
                        </a>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    </section>
</main>

<footer class="bg-dark text-white text-center py-4">
    <div class="container">
        <h5>Seguinos en Instagram</h5>
        <div class="iconos-sociales">
            <a href="https://www.instagram.com/linkejemploinstagramcooperadora" class="text-white mx-2" title="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
        <hr class="my-4" />
        <p>Contacto: <a href="mailto:cooperadora123@example.com" class="text-white">cooperadora123@example.com</a></p>
        <p>&copy; 2024 Cooperadora Escolar. Todos los derechos reservados.</p>
    </div>
</footer>

</body>
</html>
