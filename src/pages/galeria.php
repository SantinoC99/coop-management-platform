<?php
/**
 * GALERIA DE FOTOS
 *
 * Muestra todas las fotos de la galeria en modo publico.
 */

require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/security.php';
require_once __DIR__ . '/../../includes/services/galeria.php';

function escapar($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

$galeria = leerGaleria();
$urlInicio = escapar(obtenerRutaProyecto('public/'));
$urlGaleria = escapar(obtenerRutaProyecto('public/galeria.php'));
$urlDonar = escapar(obtenerRutaProyecto('public/donar.php'));
$urlAdmin = escapar(obtenerRutaProyecto('public/iniciarSesion.php'));
$urlLogo = escapar(obtenerRutaProyecto('img/LogoChaca.png'));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de imágenes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="<?php echo $urlLogo; ?>" type="image/x-icon">

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

        .barra-superior {
            backdrop-filter: blur(10px);
            background: rgba(248, 251, 253, 0.88);
            border-bottom: 1px solid rgba(216, 225, 232, 0.95);
        }

        .portada {
            background: linear-gradient(135deg, var(--portada-a) 0%, var(--portada-b) 100%);
            color: #fff;
            border-radius: 28px;
            padding: 2.3rem;
            box-shadow: 0 24px 48px rgba(16, 32, 48, 0.18);
        }

        .grilla-galeria > div {
            display: flex;
        }

        .tarjeta-galeria {
            width: 100%;
            border-radius: 24px;
            overflow: hidden;
            background: var(--superficie);
            border: 1px solid var(--borde-suave);
            box-shadow: 0 25px 32px rgba(16, 32, 48, 0.08);
        }

        .efecto-hover {
            position: relative;
            overflow: hidden;
        }

        .efecto-hover img {
            display: block;
            transition: transform 0.3s ease;
            width: 100%;
            height: 280px;
            object-fit: cover;
        }

        .efecto-hover:hover img {
            transform: scale(1.1);
            filter: blur(2px);
        }

        .capa-descripcion {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .efecto-hover:hover .capa-descripcion {
            opacity: 1;
        }

        .capa-descripcion h2 {
            color: #fff;
            font-size: 1.1rem;
            text-align: center;
            margin: 0;
            padding: 0 1rem;
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

            .efecto-hover img {
                height: 220px;
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
                    <span>Inicio</span>
                </a>
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
        <p class="text-uppercase mb-2">Registro visual</p>
        <h1 class="display-5 mb-3">Galería de la comunidad escolar</h1>
        <p class="lead mb-0">Una selección de imágenes de actividades, mejoras y momentos compartidos dentro de la escuela.</p>
    </section>

    <?php if (empty($galeria)): ?>
        <div class="alert alert-secondary text-center">Todavía no hay fotos publicadas en la galería.</div>
    <?php else: ?>
        <div class="row g-4 grilla-galeria">
            <?php foreach ($galeria as $foto): ?>
                <?php
                $descripcion = escapar($foto['descripcion'] ?? 'Sin descripción');
                $urlImagen = $urlLogo;

                if (!empty($foto['imagen'])) {
                    $rutaRelativa = ltrim((string) $foto['imagen'], '/');
                    $urlImagen = escapar(obtenerRutaProyecto($rutaRelativa));
                }
                ?>
                <div class="col-sm-6 col-lg-4">
                    <div class="tarjeta-galeria">
                        <div class="efecto-hover" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalImagen" data-image="<?php echo $urlImagen; ?>" data-description="<?php echo $descripcion; ?>">
                            <img src="<?php echo $urlImagen; ?>" class="img-fluid" alt="<?php echo $descripcion; ?>" onerror="this.src='<?php echo $urlLogo; ?>';">
                            <div class="capa-descripcion">
                                <h2><?php echo $descripcion; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<!-- Pie de pagina -->
<footer class="bg-dark text-white text-center py-4">
    <div class="container">
        <h5>Seguinos en Instagram</h5>
        <div class="iconos-sociales">
            <a href="https://www.instagram.com/tecnica6moron_oficial/?hl=es" class="text-white mx-2" title="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
        <hr class="my-4" />
        <p>Contacto: <a href="mailto:example123@gmail.com" class="text-white">example123@gmail.com</a></p>
        <p>&copy; 2024 Cooperadora Escolar. Todos los derechos reservados.</p>
    </div>
</footer>

<!-- Ventana modal para ver imagenes en grande -->
<div class="modal fade" id="modalImagen" tabindex="-1" aria-labelledby="tituloModalImagen" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content bg-dark">
      <div class="modal-header border-0">
        <h5 class="modal-title text-white" id="tituloModalImagen"></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <img id="imagenModal" src="" class="img-fluid" alt="" style="max-height: 80vh;">
      </div>
    </div>
  </div>
</div>

<script>
const modalImagen = document.getElementById('modalImagen');

if (modalImagen) {
    modalImagen.addEventListener('show.bs.modal', function (event) {
        const tarjeta = event.relatedTarget;
        const rutaImagen = tarjeta.getAttribute('data-image');
        const descripcionImagen = tarjeta.getAttribute('data-description');

        const imagenModal = document.getElementById('imagenModal');
        const tituloModal = document.getElementById('tituloModalImagen');

        imagenModal.src = rutaImagen;
        imagenModal.alt = descripcionImagen;
        tituloModal.textContent = descripcionImagen;
    });
}
</script>

</body>
</html>
