# PRD: Módulo de Control de Ingresos y Egresos

## Problem Statement

Como administrador del negocio, necesito registrar y controlar todos los ingresos y egresos financieros para tener visibilidad sobre la salud económica del negocio, clasificarlos por tipo (operativo, no operativo, capital) y generar reportes que me ayuden a tomar decisiones informadas.

## Solution

Un módulo dentro del dashboard de administración que permita:
- Registrar transacciones de ingreso y egreso con clasificación por tipo
- Subir comprobantes (facturas, recibos) como archivos adjuntos
- Visualizar un balance financiero con gráficas de tendencia
- Exportar reportes a formato descargable

---

## User Stories

1. Como admin, quiero registrar un ingreso indicando monto, fecha, tipo y descripción, para mantener un registro financiero
2. Como admin, quiero registrar un egreso de la misma forma, para controlar salidas de dinero
3. Como admin, quiero clasificar cada transacción como "Ingreso Operativo", "Ingreso No Operativo" o "Ingreso de Capital", para analizar la naturaleza de los ingresos
4. Como admin, quiero clasificar cada egreso como "Egreso Operativo", "Egreso No Operativo" o "Egreso de Capital", para analizar la naturaleza de los egresos
5. Como admin, quiero definir mis propias subcategorías (ej: "Ventas", "Alquiler", "Sueldos"), para personalizar la clasificación
6. Como admin, quiero subir un archivo comprobante (imagen o PDF) a cada transacción, para tener respaldo documental
7. Como admin, quiero ver un listado de todas las transacciones con filtros por fecha, tipo y categoría, para encontrar rápidamente una operación
8. Como admin, quiero ver el balance total (ingresos - egresos) en un dashboard, para conocer la situación financiera actual
9. Como admin, quiero ver gráficas de ingresos vs egresos por mes, para identificar tendencias
10. Como admin, quiero exportar el reporte de transacciones a un archivo descargable, para compartir o archivar la información
11. Como admin, quiero editar una transacción registrada, para corregir errores
12. Como admin, quiero eliminar una transacción, para remover registros incorrectos
13. Como admin, quiero ver el total de ingresos operativos, no operativos y de capital por separado, para análisis detallado
14. Como admin, quiero ver el total de egresos por tipo de la misma forma, para análisis detallado
15. Como admin, quiero ver las transacciones del día actual en el dashboard, para un resumen rápido
16. Como admin, quiero ver las transacciones del mes en curso, para un resumen mensual
17. Como admin, quiero ver un desglose por categoría (cuánto ingresé por "Ventas", cuánto egresé por "Sueldos"), para entender de dónde viene el dinero
18. Como admin, quiero ver el balance acumulado del año en curso, para visión anual
19. Como admin, quiero poder buscar transacciones por descripción, para localizar registros específicos
20. Como admin, quiero que el monto acepte decimales, para registrar cantidades exactas

---

## Implementation Decisions

**Models:**
- `Transaction` — modelo principal con campos: `type` (ingreso/egreso), `classification` (operativo/no_operativo/capital), `category_id`, `amount`, `description`, `date`, `attachment_path`, `user_id`
- `TransactionCategory` — categorías definidas por el usuario: `name`, `type` (ingreso/egreso), `user_id`

**Tablas:**
- `transactions` — registro de cada transacción
- `transaction_categories` — catálogo de categorías personalizadas

**Relaciones:**
- `Transaction` belongsTo `User`
- `Transaction` belongsTo `TransactionCategory`
- `TransactionCategory` hasMany `Transaction`

**Controladores:**
- `TransactionController` — CRUD completo (index, create, store, show, edit, update, destroy)
- `TransactionCategoryController` — CRUD para categorías
- `FinanceDashboardController` — dashboard con balance, gráficas y resúmenes

**Vistas:**
- `dashboard/finanzas/index.blade.php` — dashboard principal con balance y gráficas
- `dashboard/finanzas/transacciones/index.blade.php` — listado con filtros
- `dashboard/finanzas/transacciones/form.blade.php` — formulario crear/editar
- `dashboard/finanzas/categorias/index.blade.php` — gestión de categorías
- `dashboard/finanzas/categorias/form.blade.php` — formulario de categoría

**Rutas (prefijo `/dashboard/finanzas`):**
- `GET /` → dashboard
- Resource `/transacciones` → CRUD
- Resource `/categorias` → CRUD
- `GET /reportes/export` → exportación

**Archivos adjuntos:**
- Almacenamiento en `storage/app/finanzas/`
- Tipos permitidos: imágenes (jpg, png) y PDF
- Validación de tamaño máximo (10MB)

**Gráficas:**
- Librería: Chart.js (disponible vía Vite/npm)
- Gráfica de barras: Ingresos vs Egresos por mes
- Gráfica de pastel: Distribución por tipo/clasificación

**Exportación:**
- Generación de CSV con las transacciones filtradas

---

## Testing Decisions

- Tests de Feature para cada acción del `TransactionController` (CRUD)
- Tests de Feature para `TransactionCategoryController`
- Tests de Feature para `FinanceDashboardController` (verificación de balance)
- Tests de Unit para el modelo `Transaction` (scopes, métodos de cálculo)
- Verificar que solo el usuario autenticado puede acceder a sus transacciones
- Verificar validación de campos requeridos y tipos de archivo adjunto

---

## Out of Scope

- Múltiples usuarios con roles (solo admin)
- Conciliación bancaria
- Integración con software contable externo
- Multi-moneda
- Presupuestos o proyecciones
- API REST (solo vistas Blade)
- Categorías de egreso predefinidas (el usuario las define)
