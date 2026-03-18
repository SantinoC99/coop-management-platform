<?php

//La foto se identifica por su indice en la URL.
session_start();
require_once '../../includes/config.php';
require_once '../../includes/services/galeria.php';
require_once '../../includes/auth.php';
require_once '../../includes/security.php';

$error = '';
if(isset($_GET['error']) && $_GET['error'] !== ''){
    $error = $_GET['error'] === 'sesion'
    ? 'La sesión del formulario venció. Volvé a intentar.'
        : (string) $_GET['error'];
}

requerirAdmin();

// Leer todas las fotos
$galeria = leerGaleria();

// Obtiene el indice de la foto a editar
$index = isset($_GET['index']) ? (int)$_GET['index'] : -1;
$foto = ($index >= 0 && $index < count($galeria)) ? $galeria[$index] : null;

// Valida que la foto existe
if(!$foto){
    header('Location: ../../src/admin/panel.php#galeria');
    exit();
}

$galeriaPublicaUrl = obtenerRutaProyecto('public/galeria.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-between align-items-center my-4 flex-wrap gap-2">
        <h1 class="m-0">Editar Foto</h1>
        <div class="d-flex gap-2">
            <a href="panel.php#galeria" class="btn btn-outline-dark">Volver al panel</a>
            <a href="<?php echo htmlspecialchars($galeriaPublicaUrl); ?>" class="btn btn-outline-primary">Ver galería pública</a>
        </div>
    </div>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="../../src/handlers/guardarEdicionFoto.php" method="POST" enctype="multipart/form-data">

        <?php echo campoCsrf(); ?>
        <input type="hidden" name="index" value="<?php echo $index; ?>">
        
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($foto['descripcion']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen Actual</label>
            <img src="../../<?php echo htmlspecialchars($foto['imagen']); ?>" class="img-fluid" alt="Imagen Actual" style="width:700px; height:400px; object-fit: cover;">
        </div>
        <div class="mb-3">
            <label for="nueva_imagen" class="form-label">Subir Nueva Imagen (opcional)</label>
            <input type="file" class="form-control" id="nueva_imagen" name="nueva_imagen" accept="image/jpeg,image/png,image/gif">
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>

</body>
</html>
