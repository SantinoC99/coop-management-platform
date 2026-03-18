<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/security.php';

function escapar($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

$urlInicio = escapar(obtenerRutaProyecto('public/'));
$urlGaleria = escapar(obtenerRutaProyecto('public/galeria.php'));
$urlDonar = escapar(obtenerRutaProyecto('public/donar.php'));
$urlAdmin = escapar(obtenerRutaProyecto('public/iniciarSesion.php'));
$urlQr = escapar(obtenerRutaProyecto('public/uploads/imgqr.png'));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --fondo-suave: #fcefef;
            --superficie: #f8eeeb;
            --borde-suave: #d8e1e8;
            --texto-principal: #060707;
            --texto-secundario: #5d6f80;
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
            border-radius: 28px;
            padding: 2.2rem;
            color: #fff;
            box-shadow: 0 24px 48px rgba(16, 32, 48, 0.18);
            position: relative;
            overflow: hidden;
        }

        .portada::after {
            content: '';
            position: absolute;
            width: 240px;
            height: 240px;
            right: -80px;
            top: -70px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.10);
        }

        .portada > * {
            position: relative;
            z-index: 1;
        }

        .tarjeta {
            background: var(--superficie);
            border: 1px solid var(--borde-suave);
            border-radius: 24px;
            box-shadow: 0 20px 34px rgba(16, 32, 48, 0.09);
            padding: 1.5rem;
            height: 100%;
        }

        .qr-imagen {
            width: 100%;
            max-width: 280px;
            max-height: 280px;
            object-fit: cover;
            border-radius: 20px;
            border: 1px solid var(--borde-suave);
            box-shadow: 0 16px 28px rgba(16, 32, 48, 0.14);
            display: block;
            margin: 0 auto;
        }

        .texto-secundario {
            color: var(--texto-secundario);
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

            .tarjeta {
                border-radius: 20px;
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

<main class="container py-4 py-lg-5">
    <section class="portada mb-4 mb-lg-5">
        <p class="text-uppercase mb-2">Aporte solidario</p>
        <h2 class="display-5 mb-3">Donar para apoyar a la escuela</h2>
        <p class="lead mb-0">Escaneando el código QR o contactando a la cooperadora podés colaborar con mejoras y actividades para toda la comunidad.</p>
    </section>

    <section class="row g-4 align-items-stretch">
        <div class="col-lg-5">
            <div class="tarjeta">
                <h3 class="h4 mb-3">Contacto de donaciones</h3>
                <p class="texto-secundario mb-2"><strong>Email:</strong> cooperadora123@example.com</p>
                <p class="texto-secundario mb-2"><strong>Teléfono:</strong> +54 11 5555-1234</p>
                <p class="texto-secundario mb-0"><strong>Instagram:</strong> @tecnica6moron_oficial</p>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="tarjeta text-center">
                <h3 class="h4 mb-3">QR de referencia</h3>
                <img src="<?php echo $urlQr; ?>" alt="Foto de referencia del QR para donar" class="qr-imagen" onerror="this.src='<?php echo escapar(obtenerRutaProyecto('img/LogoChaca.png')); ?>';">
                <p class="texto-secundario mt-3 mb-0">Reemplaza esta foto por el QR real de la cuenta de cooperadora cuando lo tengas.</p>
            </div>
        </div>
    </section>
</main>

<footer class="bg-dark text-white text-center py-4">
    <div class="container">
        <p class="mb-1">Cooperadora Escolar</p>
        <p class="mb-0">Gracias por colaborar con la educación pública.</p>
    </div>
</footer>

</body>
</html>
