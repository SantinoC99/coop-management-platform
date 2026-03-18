<?php
require_once __DIR__ . '/../config.php';

function obtenerTablaAdmins(){

    return defined('ADMIN_USERS_TABLE') ? (string) constant('ADMIN_USERS_TABLE') : 'usuarios_admin';
}

function conectarAdminDb()
{
    mysqli_report(MYSQLI_REPORT_OFF);

    $conn = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if($conn->connect_error) {
        return null;
    }

    $conn->set_charset('utf8mb4');
    return $conn;
}

function autenticarAdmin($usuario, $clave){
    $conn = conectarAdminDb();
    if(!$conn){
        return ['success' => false, 'error' => 'db'];
    }

    $tablaAdmins = preg_replace('/[^a-zA-Z0-9_]/', '', obtenerTablaAdmins());
    $sql = 'SELECT id, usuario, clave_hash FROM ' .$tablaAdmins. ' WHERE usuario = ? LIMIT 1';

    $stmt = $conn->prepare($sql);
    if (!$stmt){
        $conn->close();
        return ['success' => false, 'error' => 'db'];
    }

    $stmt->bind_param('s', $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result ? $result->fetch_assoc() : null;

    $stmt->close();
    $conn->close();

    if(!$admin || !password_verify($clave, $admin['clave_hash'])){
        return ['success' => false, 'error' => 'credenciales'];
    }

    return[
        'success' => true,
        'admin' => [
            'id' => (int) $admin['id'],
            'usuario' => $admin['usuario'],
            'username' => $admin['usuario'],
        ],
    ];
}
?>