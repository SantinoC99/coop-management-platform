<?php

session_start();

require_once '../../includes/config.php';
require_once '../../includes/services/galeria.php';
require_once '../../includes/auth.php';
require_once '../../includes/security.php';

function escapar($valor){
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

requerirAdmin();

$error = '';
if(isset($_GET['error']) && $_GET['error'] !== ''){
    $error = $_GET['error'] === 'sesion'
    ? 'La sesión del formulario venció. Volvé a intentar.'
        : (string) $_GET['error'];
}

$urlPanel = 'panel.php#galeria';
$urlGaleriaPublica = escapar(obtenerRutaProyecto('public/galeria.php'));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../../img/LogoChaca.png" type="image/x-icon">
</head>
<body>
<header class="encabezado-personalizado text-dark py-3 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="<?php echo $urlPanel; ?>">
                <h1 class="m-0">Cooperadora Escolar</h1>
            </a>
            <div class="d-flex">
                <a href="<?php echo $urlPanel; ?>" class="btn btn-outline-dark me-2">Panel</a>
                <a href="<?php echo $urlGaleriaPublica; ?>" class="btn btn-outline-primary me-2">Ver pública</a>
                <a href="../handlers/cerrarSesion.php" class="btn btn-outline-danger">Cerrar sesión</a>
            </div>
        </div>
    </div>
</header>


<div class="container">
    <h1 class="my-4 text-center">Agregar foto a la galería</h1>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo escapar($error); ?>
        </div>
    <?php endif; ?>

    <form action="../../src/handlers/guardarFoto.php" method="POST" enctype="multipart/form-data">
        <?php echo campoCsrf(); ?>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción de la foto</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Subir imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Agregar foto</button>
    </form>
</div>


<footer class="bg-dark text-white text-center py-4 mt-5">
    <div class="container">
        <h5>Seguinos en Instagram</h5>
        <div class="iconos-sociales">
            <a href="https://www.instagram.com/linkcooperadorainstagram/?hl=es" class="text-white mx-2" title="Instagram">
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
