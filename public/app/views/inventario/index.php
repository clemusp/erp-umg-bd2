<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ERP - Inventario</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <div class="container my-4">
    <div class="row align-items-center">

      <div class="col-3"></div>


      <div class="col-6 text-center">
        <h1>Módulo de Inventario</h1>
      </div>


      <div class="col-3 text-end">
        <a href="index.php" class="btn btn-outline-secondary">&larr; Regresar</a>
      </div>
    </div>
  </div>


  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-6">
        <form id="formInventario">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Producto</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>
          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="precio" class="form-label">Precio Unitario</label>
            <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
          </div>
          <div class="mb-4">
            <label for="stock" class="form-label">Stock Inicial</label>
            <input type="number" class="form-control" id="stock" name="stock" required>
          </div>

          <button type="submit" class="btn btn-success w-100 py-2">Agregar Producto</button>
        </form>

        <button id="btnStock" class="btn btn-primary w-100 py-2 mt-3">Stock</button>


        <div id="respuesta" class="mt-4 text-center fw-semibold text-secondary"></div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="stockModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="stockModalLabel">Listado de Productos</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">

          <div class="table-responsive">
            <table class="table table-bordered" id="tablaStock">
              <thead class="table-light">
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Descripción</th>
                  <th>Precio Unitario</th>
                  <th>Stock</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" id="btnActualizarStock" class="btn btn-success">Actualizar</button>
          <button type="button" id="btnCerrarStock" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

  <script src="js/inventario.js" defer></script>

</body>
</html>