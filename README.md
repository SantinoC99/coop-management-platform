# Coop Management Platform 
**Plataforma web para cooperadora escolar**

Gestión de donaciones, difusión de noticias, galería de eventos y transparencia de necesidades escolares.

Proyecto final de pasantía profesionalizante.

**Stack:** PHP 8 | MySQL/MariaDB | Bootstrap 5 | JSON

---

## Resumen

Aplicación web responsive creada a partir de necesidades relevadas en entrevistas con usuarios de la institución, para modernizar la comunicación de la cooperadora y reemplazar procesos manuales en papel.

Resuelve un problema real con dos superficies claras:

- Sitio público de lectura (noticias, galería, información de aportes)
- Panel administrativo para gestión de contenido

---

## Instalación rápida (local)
1. Clonar el proyecto en `htdocs`:
	```bash
	cd C:\xampp\htdocs
	git clone https://github.com/SantinoC99/coop-management-platform.git
	cd coop-management-platform
	```
2. Iniciar Apache y MySQL desde XAMPP.
3. Importar `db/admin_auth.sql` en phpMyAdmin.
4. Verificar permisos de escritura en:
	```
	public/uploads/galeria/
	public/uploads/noticias/
	data/noticias.json
	data/galeria.json
	```
5. Abrir:
- Sitio público: `http://localhost/coop-management-platform/public/`
- Login admin: `http://localhost/coop-management-platform/public/iniciarSesion.php`

Credenciales iniciales tras importar SQL:
- Usuario: `admin`
- Contraseña: `admin`

⚠️ Importante: son credenciales de prueba local, no de despliegue.

---

## Requerimientos relevados

Se realizaron entrevistas con usuarios de la institución y se definieron estos objetivos:

- Difusión moderna de novedades y actividades
- Facilidad para comunicar necesidades y fomentar aportes
- Transparencia sobre necesidades y compras realizadas
- Panel simple para usuarios no técnicos

---

## Responsabilidades asumidas

- Recolección de requerimientos mediante entrevistas
- Diseño de arquitectura híbrida (SQL + JSON)
- Implementación de frontend y backend
- Testeo y validación con usuarios finales

---

## Características principales

### Sitio público

- Portada responsiva
- Galería de fotos con descripción
- Noticias ordenadas por fecha (más reciente primero)
- Vista de detalle de noticia
- Página de datos para aportes

### Panel administrativo

- Login admin protegido
- Crear, editar y eliminar noticias
- Subir y eliminar fotos de galería
- Vista previa pública de cambios
- Instructivo paso a paso para usuarios no técnicos

### Seguridad

- Tokens CSRF en formularios
- Contraseñas con hash bcrypt
- Prepared statements (prevención SQL injection)
- Validación de imágenes por MIME type y extensión
- Escape de HTML en vistas (prevención XSS)

---

## Arquitectura

Decisión de diseño: híbrida (SQL + JSON).

- MySQL: autenticación del administrador
- JSON: contenido editorial (noticias y galería)

Con esto se prioriza seguridad en el acceso admin y simplicidad para el contenido de baja concurrencia.

Más detalle en [docs/arquitectura-hibrida.md](docs/arquitectura-hibrida.md).

---

## Estructura del proyecto

```
coop-management-platform/
├── public/              # Puntos de entrada públicos
│   ├── index.php
│   ├── galeria.php
│   ├── detalleNoticia.php
│   ├── iniciarSesion.php
│   └── uploads/
├── src/
│   ├── pages/           # Vistas públicas
│   ├── admin/           # Panel admin
│   └── handlers/        # Procesamiento de formularios
├── includes/
│   ├── config.php
│   ├── auth.php
│   ├── security.php
│   └── services/
├── db/
│   └── admin_auth.sql
├── data/
│   ├── noticias.json
│   └── galeria.json
└── docs/
```

---

## Valor del proyecto

- Reemplazo de gestión en papel por flujo digital
- Publicación centralizada de noticias y eventos
- Transparencia de necesidades y compras escolares
- Gestión de contenido por usuarios no técnicos
- Base de seguridad para autenticación y formularios

