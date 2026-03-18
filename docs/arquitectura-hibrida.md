# Decisión Técnica: Arquitectura Híbrida (SQL + JSON)

## Contexto

El sistema fue diseñado para una cooperadora escolar con:

- Bajo volumen de contenido.
- Pocas escrituras simultáneas.
- Necesidad de operación simple y fácil mantenimiento.
- Un único panel de administración con acceso protegido.

## Decisión y Justificación

Se eligió una arquitectura híbrida:

- **MySQL:** Autenticación del administrador (credenciales hasheadas, control estricto de acceso)
- **JSON:** Noticias y galería (bajo volumen, fácil de respaldar y portar entre entornos)

Razones principales:
- Reducir complejidad operativa para contenido editorial simple
- Mejorar portabilidad entre entornos de desarrollo/producción
- Mantener máxima seguridad en autenticación admin
- URLs públicas limpias sin exponer rutas internas (usando `require_once` en puntos de entrada)
- Facilitar crecimiento futuro a múltiples administradores sin rehacer la base de autenticación

## Análisis de la decisión

Se evaluaron alternativas: todo SQL (mejor para escala pero más complejo) vs. todo JSON (simple pero limitado en seguridad). La arquitectura híbrida balancea ambas: MySQL asegura autenticación robusta; JSON mantiene contenido portable y fácil de respaldar.

**Trade-offs aceptados:** Escalabilidad limitada para escrituras concurrentes, menor capacidad de análisis complejos. Si en futuro hay múltiples administradores editando simultáneamente o crece significativamente el contenido, se migrará noticias/galería a SQL completo.
