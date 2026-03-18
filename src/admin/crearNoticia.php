<?php

session_start();
require_once '../../includes/config.php';
require_once '../../includes/services/noticias.php';
require_once '../../includes/auth.php';
require_once '../../includes/security.php';

$error = '';
if(isset($_GET['error']) && $_GET['error'] !== ''){
    $error = $_GET['error'] === 'sesion'
    ? 'La sesión del formulario venció. Volvé a intentar.'
        : (string) $_GET['error'];
}

requerirAdmin();
$sitioPublicoUrl = obtenerRutaProyecto('public/');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Noticia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../../img/LogoChaca.png" type="image/x-icon">
    <style>
        body{
            background: #f5f7fb;
        }
        .contenedor-editor {
            max-width: 860px;
        }
        .tarjeta-editor {
            border: 0;
            border-radius: 20px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        }
    </style>
</head>

<body>
    <div class="container py-4 contenedor-editor">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <h1 class="m-0">Nueva Noticia</h1>
            <div class="d-flex gap-2">
                <a href="panel.php#noticias" class="btn btn-outline-dark">Volver al panel</a>
                <a href="<?php echo htmlspecialchars($sitioPublicoUrl); ?>" class="btn btn-outline-primary">Ver sitio público</a>
            </div>
        </div>

        <div class="card tarjeta-editor">
            <div class="card-body p-4 p-lg-5">
                <?php if ($error !== ''): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form action="../../src/handlers/guardarNoticia.php" method="POST" enctype="multipart/form-data">

                    <?php echo campoCsrf(); ?>

                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="subtitulo" class="form-label">Subtítulo o fecha visible</label>
                        <input type="text" class="form-control" id="subtitulo" name="subtitulo" placeholder="Ejemplo: 13 de marzo de 2026 | Jornada institucional">
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción breve</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="detalles" class="form-label">Descripción detallada</label>
                        <textarea class="form-control" id="detalles" name="detalles" rows="6"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="imagen" class="form-label">Imagen (opcional)</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/jpeg,image/png,image/gif">
                    </div>
                    <button type="submit" class="btn btn-primary">Publicar Noticia</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
