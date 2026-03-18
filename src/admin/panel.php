<?php
session_start();

require_once '../../includes/config.php';
require_once '../../includes/services/noticias.php';
require_once '../../includes/services/galeria.php';
require_once '../../includes/auth.php';
require_once '../../includes/security.php';

requerirAdmin();

$noticias = leerNoticias();
$galeria = leerGaleria();
$error = '';
$sitioPublicoUrl = obtenerRutaProyecto('public/');
$galeriaPublicaUrl = obtenerRutaProyecto('public/galeria.php');
$detallePublicoUrl = obtenerRutaProyecto('public/detalleNoticia.php');

if (isset($_GET['error']) && $_GET['error'] !== '') {
    $error = $_GET['error'] === 'sesion'
    ? 'La sesión del formulario venció. Recarga la página e intenta de nuevo.'
        : (string) $_GET['error'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="../../img/LogoChaca.png" type="image/x-icon">
    <style>
        body {
            background: #f5f7fb;
        }

        .portada{
            background: linear-gradient(135deg, #17324d 0%, #2a5d8f 100%);
            color: #fff;
            border-radius: 18px;
            padding: 32px;
            margin-bottom: 24px;
        }

        .summary-card{
            border: 0;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }

        .content-card{
            border: 0;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .miniatura{
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: #dde6ee;
        }

        .empty-state{
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            color: #64748b;
            background: #fff;
        }
    </style>

    <script>
        function confirmarAccion(mensaje){
            return confirm(mensaje);
        }
    </script>

</head>
<body>
    <div class="container py-4">
        <section class="portada">
            <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-center">
                <div>
                    <p class="text-uppercase mb-2">Administración</p>
                    <h1 class="h2 mb-2">Panel de contenido</h1>
                    <p class="mb-0">Desde acá gestionas las noticias y la galería que ve el público.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-light" href="<?php echo htmlspecialchars($sitioPublicoUrl); ?>">Ver sitio público</a>
                    <a class="btn btn-outline-light" href="<?php echo htmlspecialchars($galeriaPublicaUrl); ?>">Ver galería pública</a>
                    <a class="btn btn-warning" href="instructivo.php">Instructivo paso a paso</a>
                    <a class="btn btn-danger" href="../handlers/cerrarSesion.php">Cerrar sesión</a>
                </div>
            </div>
        </section>

        <?php if ($error !== ''): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <section class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card summary-card">
                    <div class="card-body">
                        <p class="text-muted mb-2">Noticias publicadas</p>
                        <h2 class="display-6 mb-0"><?php echo count($noticias); ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card summary-card">
                    <div class="card-body">
                        <p class="text-muted mb-2">Fotos en galería</p>
                        <h2 class="display-6 mb-0"><?php echo count($galeria); ?></h2>
                    </div>
                </div>
            </div>
        </section>

        <section id="noticias" class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3 gap-2 flex-wrap">
                <div>
                    <h2 class="h3 mb-1">Noticias</h2>
                    <p class="text-muted mb-0">Administra lo que aparece en la página principal pública.</p>
                </div>
                <a class="btn btn-primary" href="crearNoticia.php">Nueva noticia</a>
            </div>

            <?php if(empty($noticias)): ?>
                <div class="empty-state">Todavía no hay noticias cargadas.</div>
            <?php else: ?>

                <div class="row g-4">
                    <?php foreach($noticias as $index => $noticia): ?>

                        <div class="col-lg-4 col-md-6">
                            <div class="card content-card h-100">
                                <?php if(!empty($noticia['imagen'])): ?>
                                    <img src="../../<?php echo htmlspecialchars($noticia['imagen']); ?>" class="miniatura" alt="<?php echo htmlspecialchars($noticia['titulo']); ?>">
                                <?php else: ?>
                                    <div class="miniatura d-flex align-items-center justify-content-center text-secondary">
                                        <i class="fas fa-image fa-2x"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body d-flex flex-column">

                                    <?php if(!empty($noticia['subtitulo'])): ?>
                                        <p class="text-uppercase text-muted small mb-2"><?php echo htmlspecialchars($noticia['subtitulo']); ?></p>
                                    <?php endif; ?>

                                    <h3 class="h5"><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                                    <p class="text-muted flex-grow-1"><?php echo htmlspecialchars($noticia['descripcion']); ?></p>

                                    <div class="d-flex flex-wrap gap-2">
                                        <a class="btn btn-warning" href="editarNoticia.php?index=<?php echo $index; ?>">Editar</a>
                                        <a class="btn btn-outline-secondary" href="<?php echo htmlspecialchars($detallePublicoUrl); ?>?index=<?php echo (int) $index; ?>">Ver pública</a>

                                        <form action="../handlers/eliminarNoticia.php" method="POST" onsubmit="return confirmarAccion('¿Eliminar esta noticia?');">
                                            
                                            <?php echo campoCsrf(); ?>

                                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <section id="galeria">
            <div class="d-flex justify-content-between align-items-center mb-3 gap-2 flex-wrap">
                <div>
                    <h2 class="h3 mb-1">Galería</h2>
                    <p class="text-muted mb-0">Administra las imágenes visibles para el público.</p>
                </div>
                <a class="btn btn-primary" href="agregarFoto.php">Nueva foto</a>
            </div>

            <?php if (empty($galeria)): ?>
                <div class="empty-state">Todavía no hay fotos cargadas en la galería.</div>
            <?php else: ?>

                <div class="row g-4">
                    <?php foreach ($galeria as $index => $foto): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="card content-card h-100">

                                <img src="../../<?php echo htmlspecialchars($foto['imagen']); ?>" class="miniatura" alt="<?php echo htmlspecialchars($foto['descripcion']); ?>">
                                
                                <div class="card-body d-flex flex-column">
                                    <h3 class="h5"><?php echo htmlspecialchars($foto['descripcion']); ?></h3>
                                    <div class="d-flex flex-wrap gap-2 mt-auto">
                                        <a class="btn btn-warning" href="editarFoto.php?index=<?php echo $index; ?>">Editar</a>
                                        <a class="btn btn-outline-secondary" href="<?php echo htmlspecialchars($galeriaPublicaUrl); ?>">Ver pública</a>

                                        <form action="../handlers/eliminarFoto.php" method="POST" onsubmit="return confirmarAccion('¿Eliminar esta foto?');">
                                            <?php echo campoCsrf(); ?>
                                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>