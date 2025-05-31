<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ERP - Ventas</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container my-4">
    <div class="row align-items-center">
      <div class="col-3"></div>
      <div class="col-6 text-center">
        <h1>Módulo de Ventas</h1>
      </div>
      <div class="col-3 text-end">
        <a href="index.php" class="btn btn-outline-secondary">&larr; Regresar</a>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8">

        <form id="facturaCabecera" class="mb-4">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="cliente" class="form-label">Cliente</label>
              <select id="cliente" class="form-select" required>
                <option value="">Seleccione un cliente</option>

              </select>
            </div>
            <div class="col-md-6">
              <label for="vendedor" class="form-label">Vendedor</label>
              <select id="vendedor" class="form-select" required>
                <option value="">Seleccione un vendedor</option>

              </select>
            </div>
            <div class="col-md-6">
              <label for="fecha" class="form-label">Fecha</label>
              <input type="date" id="fecha" class="form-control" value="" required>
            </div>
          </div>
        </form>

        <div class="table-responsive">
          <table class="table table-bordered" id="tablaDetalles">
            <thead class="table-light">
              <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
              <tr>
                <td colspan="3" class="text-end fw-bold">Total:</td>
                <td id="totalFactura">0.00</td>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>


        <div class="d-grid gap-2">
          <button id="btnAgregarLinea" class="btn btn-secondary py-2">Agregar Línea</button>
          <button id="btnGenerarFactura" class="btn btn-primary py-2">Generar Factura</button>
        </div>


        <div id="respuestaVentas" class="mt-4 text-center text-success fw-semibold"></div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>


  <script>
  document.addEventListener('DOMContentLoaded', () => {

    fetch('clientes.php')
      .then(res => res.json())
      .then(lista => {
        const selCliente = document.getElementById('cliente');
        lista.forEach(c => {
          const opt = document.createElement('option');
          opt.value = c.ClienteID;
          opt.textContent = c.Nombre;
          selCliente.appendChild(opt);
        });
      })
      .catch(err => console.error('Error al cargar clientes:', err));


    fetch('vendedores.php')
      .then(res => res.json())
      .then(lista => {
        const selVendedor = document.getElementById('vendedor');
        lista.forEach(v => {
          const opt = document.createElement('option');
          opt.value = v.VendedorID;
          opt.textContent = v.Nombre;
          selVendedor.appendChild(opt);
        });
      })
      .catch(err => console.error('Error al cargar vendedores:', err));
  });
  </script>

  <script src="js/ventas.js" defer></script>
</body>
</html>
