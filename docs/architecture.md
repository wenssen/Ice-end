# Sistema de gestión de stock - Ice-end

## Objetivo
Proveer una referencia de arquitectura y endpoints REST para implementar un sistema de gestión de stock basado en el esquema `gestion_stock_ice_end`.

## Módulos principales
- **Proveedores y abastecimiento**: CRUD de proveedores (`proveedor`) y gestión de precios/plazos por materia prima (`abastece`).
- **Materias primas**: CRUD de artículos (`materia_prima`), control de stock y alertas por `stock_minimo`.
- **Compras**: creación y seguimiento de órdenes de compra (`orden_compra`) y sus detalles (`detalle_orden_compra`).
- **Recetas**: definición de insumos por producto (`receta`).
- **Producción**: planes de producción (`plan_produccion`), detalle de productos a fabricar (`detalle_plan_producto`) y consumos ligados a pedidos de producción (`pedido_pd`, `detalle_pedido_pd`).
- **Productos terminados**: catálogo y stock de productos finales (`producto_terminado`).

## Flujo sugerido
1. **Alta de proveedores y materias primas**.
2. **Definir recetas** por producto terminado (cantidades por `unidad_medida`).
3. **Crear pedido de producción** (`pedido_pd`) y asociar planes (`detalle_pedido_pd`).
4. **Planificar producción** con fechas de plan y ejecución (`plan_produccion`).
5. **Generar requerimientos de compra** usando recetas × cantidad a producir; disparar órdenes de compra cuando el stock < `stock_minimo`.
6. **Registrar recepciones** de órdenes de compra para actualizar `stock_actual` de `materia_prima`.
7. **Cerrar plan de producción** decrementando materias primas según receta y cantidad producida, e incrementando `stock_actual` de `producto_terminado`.

## Modelo de datos (resumen)
- **proveedor** (1) —< **abastece** >— (1) **materia_prima**
- **orden_compra** (1) —< **detalle_orden_compra** >— (1) **materia_prima**
- **producto_terminado** (1) —< **receta** >— (1) **materia_prima**
- **plan_produccion** —< **detalle_plan_producto** >— **producto_terminado**
- **pedido_pd** —< **detalle_pedido_pd** >— **plan_produccion**

## API REST propuesta
Usando rutas `/api/v1` y JSON.

### Proveedores
- `GET /proveedores` lista.
- `POST /proveedores` crear.
- `GET /proveedores/{id}` detalle.
- `PUT /proveedores/{id}` actualizar.
- `PATCH /proveedores/{id}/estado` activar/inactivar.

### Materias primas
- `GET /materias-primas` con filtros por `stock_actual` < `stock_minimo`.
- `POST /materias-primas` crear.
- `GET /materias-primas/{id}` detalle.
- `PUT /materias-primas/{id}` actualizar.
- `PATCH /materias-primas/{id}/stock` ajustar stock.

### Productos terminados y recetas
- `GET /productos` lista.
- `POST /productos` crear.
- `GET /productos/{id}` detalle con receta.
- `PUT /productos/{id}` actualizar.
- `PUT /productos/{id}/receta` reemplazar ingredientes (array `{id_materia_prima,cantidad_requerida}`).

### Compras
- `POST /ordenes-compra` crear OC con detalles.
- `GET /ordenes-compra` listar con filtros por estado.
- `GET /ordenes-compra/{id}` detalle.
- `PATCH /ordenes-compra/{id}/estado` (`pendiente|recibida|cancelada`).
- `POST /ordenes-compra/{id}/recepciones` registrar recepción parcial o total; recalcula `stock_actual`.

### Producción
- `POST /pedidos-pd` crear pedido.
- `GET /pedidos-pd` listar.
- `POST /planes-produccion` crear plan con `detalle_plan_producto`.
- `PATCH /planes-produccion/{id}/estado` (`planificado|en_proceso|finalizado`).
- `POST /planes-produccion/{id}/consumos` descontar materias primas según recetas y cantidades reales; actualiza stock de producto terminado.

## Lógica de negocio clave
- **Reabastecimiento**: al crear/actualizar `materia_prima`, emitir alerta si `stock_actual < stock_minimo`. Al recibir compra, recalcular stock y marcar OC `recibida` cuando todos los detalles estén completos.
- **Consumo de insumos**: para cada producto en `detalle_plan_producto`, descontar `receta.cantidad_requerida * cantidad_a_producir` de `materia_prima.stock_actual`; bloquear cuando no hay stock suficiente.
- **Costo estándar**: calcular costo unitario del producto usando receta × `costo_unitario` de materias primas; guardar en caché o columna derivada si se necesita rendimiento.

## Integraciones y capas
- **Backend**: API REST (Laravel, FastAPI o Express) con capa de servicios y repositorios por agregado.
- **Base de datos**: MariaDB/MySQL con migraciones equivalentes al esquema provisto.
- **Frontend**: SPA (Vue/React) o Blade para CRUD; dashboards de stock bajo mínimos y OC pendientes.
- **Autenticación**: JWT/Sesiones; roles `admin`, `compras`, `produccion` para restringir endpoints críticos.

## Consultas útiles
- Materias primas bajo mínimo:
  ```sql
  SELECT * FROM materia_prima WHERE stock_actual < stock_minimo;
  ```
- Requerimientos para un plan de producción:
  ```sql
  SELECT dpp.id_plan_produccion, r.id_materia_prima,
         SUM(dpp.cantidad_a_producir * r.cantidad_requerida) AS cantidad_total
  FROM detalle_plan_producto dpp
  JOIN receta r ON r.id_producto = dpp.id_producto
  WHERE dpp.id_plan_produccion = ?
  GROUP BY dpp.id_plan_produccion, r.id_materia_prima;
  ```
- Costo estimado de un producto:
  ```sql
  SELECT SUM(r.cantidad_requerida * mp.costo_unitario) AS costo_estandar
  FROM receta r
  JOIN materia_prima mp ON mp.id_materia_prima = r.id_materia_prima
  WHERE r.id_producto = ?;
  ```

## Roadmap de implementación
1. Configurar proyecto backend y migrar el esquema.
2. Implementar repositorios/ORM por tabla y servicios de dominio.
3. Exponer endpoints REST anteriores con validaciones y transacciones.
4. Construir UI: dashboard de alertas, CRUDs y flujo de OC/producción.
5. Añadir pruebas unitarias/integración para reglas de stock y consumos.

## Métricas y monitoreo
- Stock bajo mínimos, OC pendientes, plazos de entrega promedio por proveedor.
- Tiempo desde `fecha_plan` a `fecha_ejecucion` y cumplimiento de producción.
