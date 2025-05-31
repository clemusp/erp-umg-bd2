<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ERP - Contabilidad</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container text-center my-4">
    <h1>Módulo de Contabilidad - Nuevo Comprobante</h1>
  </div>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8">

        <form id="formComprobante" class="mb-4">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="fechaComp" class="form-label">Fecha</label>
              <input type="date" class="form-control" id="fechaComp" required>
            </div>
            <div class="col-md-6">
              <label for="descripcionComp" class="form-label">Descripción</label>
              <input type="text" class="form-control" id="descripcionComp" placeholder="Concepto" required>
            </div>
          </div>
        </form>

        <div class="table-responsive">
          <table class="table table-bordered" id="tablaComprobante">
            <thead class="table-light">
              <tr>
                <th>Cuenta</th>
                <th>Descripción</th>
                <th>Debe</th>
                <th>Haber</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="2" class="text-end fw-bold">Totales:</td>
                <td id="totalDebe">0.00</td>
                <td id="totalHaber">0.00</td>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>


        <div class="d-grid gap-2">
          <button id="btnAgregarLineaComp" class="btn btn-secondary py-2">Agregar Línea</button>
          <button id="btnGuardarComp" class="btn btn-success py-2">Guardar Comprobante</button>
        </div>

        <div id="respuestaContabilidad" class="mt-4 text-center text-danger fw-semibold"></div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

  <script src="js/contabilidad.js" defer></script>
</body>
</html>