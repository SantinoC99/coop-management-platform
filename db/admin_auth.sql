CREATE DATABASE IF NOT EXISTS proyecto_cooperadora CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE proyecto_cooperadora;

CREATE TABLE IF NOT EXISTS usuarios_admin (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    usuario VARCHAR(50) NOT NULL,
    clave_hash VARCHAR(255) NOT NULL,
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_usuarios_admin_usuario (usuario)
);

INSERT INTO usuarios_admin (usuario, clave_hash)
VALUES ('admin', '$2y$10$dSiV6ZNqmQ6FLYdpzMqRC.p8FWSsa8VTNGV91935mxKyIQilHF.BO')
ON DUPLICATE KEY UPDATE
    usuario = VALUES(usuario),
    clave_hash = VALUES(clave_hash);