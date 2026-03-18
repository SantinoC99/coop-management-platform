<?php
session_start();
require_once '../includes/security.php';

// Convierte cualquier valor a texto y lo escapa para mostrarlo en HTML sin que se interprete como codigo.
function escapar($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

$error = '';

if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){
    header('Location: ../src/admin/panel.php');
    exit();
}

if(isset($_GET['error']) && $_GET['error'] === 'credenciales'){
    $error = 'Credenciales de administrador incorrectas.';
} elseif(isset($_GET['error']) && $_GET['error'] === 'db'){
    $error = 'No se pudo conectar a la base de datos del administrador.';
} elseif(isset($_GET['error']) && $_GET['error'] === 'sesion'){
    $error = 'La sesión del formulario venció. Volvé a intentarlo.';
}
//Arma la ruta publica del proyecto y la deja segura para usarla en el enlace.
$urlSitioPublico = escapar(obtenerRutaProyecto('public/'));
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root{
            /* Variables globales de CSS para los colores principales de la pagina */
            --fondo-suave: #fcefef;
            --superficie: #f8eeeb;
            --borde-suave: #d8e1e8;
            --portada-a: #be0f0f;
        }

        body{
            background:
                radial-gradient(circle at top right, rgba(255, 139, 123, 0.33), transparent 24%),
                linear-gradient(180deg, #f8fbfd 0%, var(--fondo-suave) 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .contenedor-acceso{
            background: var(--superficie);
            border: 1px solid var(--borde-suave);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 16px 30px rgba(16, 32, 48, 0.12);
            width: 100%;
            max-width: 420px;
        }

        .btn-primary {
            background-color: var(--portada-a);
            border-color: var(--portada-a);
        }

        .btn-primary:hover {
            background-color: #960d0d;
            border-color: #960d0d;
        }
    </style>
</head>

<body>
    <div class="contenedor-acceso">
        <h1 class="text-center mb-4">Acceso de administración</h1>
        <p class="text-center text-muted">Solo el administrador puede editar el contenido público.</p>
        
        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo escapar($error); ?>
            </div>
        <?php endif; ?>

        <form action="../src/handlers/procesarLogin.php" method="POST">
            <?php echo campoCsrf(); ?>
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="mb-3">
                <label for="clave" class="form-label">Clave</label>
                <input type="password" class="form-control" id="clave" name="clave" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
        
        <hr>
        <p class="text-center text-muted"><small>Las credenciales del administrador se gestionan desde la base de datos del proyecto.</small></p>
        <p class="text-center">
            <a href="<?php echo $urlSitioPublico; ?>">Volver al sitio público</a>
        </p>
    </div>
</body>
</html>
