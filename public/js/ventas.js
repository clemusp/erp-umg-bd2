// public/js/ventas.js

document.addEventListener('DOMContentLoaded', () => {
  const btnAgregarLinea   = document.getElementById('btnAgregarLinea');
  const btnGenerar        = document.getElementById('btnGenerarFactura');
  const tablaDetallesTbody = document.querySelector('#tablaDetalles tbody');
  const totalFacturaCell  = document.getElementById('totalFactura');
  const respuestaElem     = document.getElementById('respuestaVentas');

  // ------------------------------------------------------------------
  // 1) AGREGAR FILAS DINÁMICAS A "DETALLES DE FACTURA"
  // ------------------------------------------------------------------

  btnAgregarLinea.addEventListener('click', async (e) => {
    e.preventDefault();

    // 1.1) Creamos un <tr> con los campos en blanco y botones necesarios
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>
        <select class="form-select producto">
          <option value="">-- Seleccionar --</option>
        </select>
      </td>
      <td><input type="number" class="form-control cantidad" min="1" value="1"></td>
      <td><input type="number" class="form-control precio" step="0.01" value="0.00"></td>
      <td class="subtotal">0.00</td>
      <td><button class="btn btn-danger btn-sm btnEliminar">X</button></td>
    `;

    // 1.2) Insertamos la fila en el tbody
    tablaDetallesTbody.appendChild(tr);

    // 1.3) Llenar el <select class="producto"> desde el backend
    try {
      const resp = await fetch('productos.php');
      const listaProductos = await resp.json(); 
      const sel = tr.querySelector('.producto');
      listaProductos.forEach(p => {
        const opt = document.createElement('option');
        opt.value = p.ProductoID;
        opt.textContent = p.Nombre;
        sel.appendChild(opt);
      });
    } catch (err) {
      console.error('Error al cargar productos:', err);
      // Si falla, dejamos únicamente la opción vacía y permitimos continuar
    }

    // 1.4) Añadimos los event listeners para recálculo y eliminación de fila
    actualizarEventosRow(tr);
  });

  function actualizarEventosRow(row) {
    const cantidadInput = row.querySelector('.cantidad');
    const precioInput   = row.querySelector('.precio');
    const subtotalCell  = row.querySelector('.subtotal');
    const btnEliminar   = row.querySelector('.btnEliminar');

    function recalcular() {
      const cantidad = parseFloat(cantidadInput.value) || 0;
      const precio   = parseFloat(precioInput.value) || 0;
      const subtotal = cantidad * precio;
      subtotalCell.textContent = subtotal.toFixed(2);
      actualizarTotal();
    }

    cantidadInput.addEventListener('input', recalcular);
    precioInput.addEventListener('input', recalcular);

    btnEliminar.addEventListener('click', (ev) => {
      ev.preventDefault();
      row.remove();
      actualizarTotal();
    });
  }

  function actualizarTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(cell => {
      total += parseFloat(cell.textContent) || 0;
    });
    totalFacturaCell.textContent = total.toFixed(2);
  }

  // ------------------------------------------------------------------
  // 2) ENVIAR LA FACTURA AL BACKEND 
  // ------------------------------------------------------------------

  btnGenerar.addEventListener('click', async (e) => {
    e.preventDefault();

    respuestaElem.textContent = '';
    respuestaElem.classList.remove('text-danger','text-success');

    // 2.1) Leemos cabecera: Cliente, Vendedor, Fecha
    const clienteID  = parseInt(document.getElementById('cliente').value, 10);
    const vendedorID = parseInt(document.getElementById('vendedor').value, 10);
    const fecha      = document.getElementById('fecha').value;

    if (!clienteID || !vendedorID || !fecha) {
      respuestaElem.textContent = 'Por favor, seleccione Cliente, Vendedor y Fecha.';
      respuestaElem.classList.add('text-danger');
      return;
    }

    // 2.2) Recorrer filas de detalle
    const filas = Array.from(tablaDetallesTbody.querySelectorAll('tr'));
    if (filas.length === 0) {
      respuestaElem.textContent = 'Debe agregar al menos una línea de detalle.';
      respuestaElem.classList.add('text-danger');
      return;
    }

    const details = [];
    for (const tr of filas) {
      const prodSel  = tr.querySelector('.producto');
      const prodID   = parseInt(prodSel.value, 10);
      const cantidad = parseInt(tr.querySelector('.cantidad').value, 10);
      const precio   = parseFloat(tr.querySelector('.precio').value);

      if (!prodID || cantidad <= 0 || precio <= 0) {
        respuestaElem.textContent = 'Cada línea debe tener Producto, Cantidad > 0 y Precio > 0.';
        respuestaElem.classList.add('text-danger');
        return;
      }

      details.push({
        ProductoID: prodID,
        Cantidad: cantidad,
        PrecioUnitario: precio
      });
    }

    // 2.3) Armamos el JSON con cabecera y detalles
    const payload = {
      header: {
        ClienteID: clienteID,
        VendedorID: vendedorID,
        Fecha: fecha
      },
      details: details
    };

    // 2.4) Enviamos POST a ventas.php
    try {
      const respuestaFetch = await fetch('ventas.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });

      const data = await respuestaFetch.json();
      if (data.success) {
        respuestaElem.textContent = '✅ Factura generada correctamente.';
        respuestaElem.classList.add('text-success');

        tablaDetallesTbody.innerHTML = '';
        actualizarTotal();
      } else {
        respuestaElem.textContent = data.message || '❌ Error al generar la factura.';
        respuestaElem.classList.add('text-danger');
      }
    } catch (err) {
      console.error(err);
      respuestaElem.textContent = '❌ Error de conexión al servidor.';
      respuestaElem.classList.add('text-danger');
    }
  });

});
