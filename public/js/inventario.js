document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('formInventario');
  const respuesta = document.getElementById('respuesta');
  const btnStock = document.getElementById('btnStock');

  form.addEventListener('submit', async e => {
    e.preventDefault();
    const formData = new FormData(form);

    try {
      const res = await fetch('inventario.php', { method: 'POST', body: formData });
      const data = await res.json();
      if (data.success) {
        respuesta.textContent = 'Producto guardado correctamente.';
        form.reset();
        alert('Datos ingresados correctamente');
      } else {
        respuesta.textContent = 'Error al guardar el producto.';
        alert('Error al guardar el producto');
      }
    } catch (err) {
      respuesta.textContent = 'Error de conexión.';
      alert('Error de conexión');
    }
  });


  const stockModalEl = document.getElementById('stockModal');
  const tablaStockBody = document.querySelector('#tablaStock tbody');
  const btnActualizarStock = document.getElementById('btnActualizarStock');

  const stockModal = new bootstrap.Modal(stockModalEl, {
    keyboard: false,
    backdrop: 'static'
  });

  // Función para cargar todos los productos
  async function cargarProductosEnTabla() {
    try {
      const res = await fetch('stock.php'); 
      const productos = await res.json();   
      // Limpiamos tbody
      tablaStockBody.innerHTML = '';


      productos.forEach(prod => {
        const tr = document.createElement('tr');
        tr.dataset.id = prod.ProductoID; 

        tr.innerHTML = `
          <td>${prod.ProductoID}</td>
          <td><input type="text" class="form-control input-nombre" value="${prod.Nombre}"></td>
          <td><input type="text" class="form-control input-descripcion" value="${prod.Descripcion}"></td>
          <td><input type="number" step="0.01" class="form-control input-precio" value="${parseFloat(prod.PrecioUnitario).toFixed(2)}"></td>
          <td><input type="number" class="form-control input-stock" value="${prod.Stock}"></td>
        `;
        tablaStockBody.appendChild(tr);
      });
    } catch (err) {
      console.error('Error al cargar productos:', err);
      tablaStockBody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Error al cargar productos</td></tr>';
    }
  }

  // Al hacer clic en el botón “Stock”, abrimos el modal y cargamos la tabla
  btnStock.addEventListener('click', () => {
    cargarProductosEnTabla().then(() => {
      stockModal.show();
    });
  });

  // Al hacer clic en “Actualizar” dentro del modal:
  btnActualizarStock.addEventListener('click', async () => {
    // Recorremos cada fila y formamos un array de objetos 
    const filas = [...tablaStockBody.querySelectorAll('tr')];
    const productosActualizados = filas.map(tr => {
      const id = parseInt(tr.dataset.id, 10);
      const nombre = tr.querySelector('.input-nombre').value.trim();
      const descripcion = tr.querySelector('.input-descripcion').value.trim();
      const precio = parseFloat(tr.querySelector('.input-precio').value) || 0;
      const stock = parseInt(tr.querySelector('.input-stock').value, 10) || 0;
      return { ProductoID: id, Nombre: nombre, Descripcion: descripcion, PrecioUnitario: precio, Stock: stock };
    });

    // Enviamos el array completo por POST a stock.php como JSON
    try {
      const res = await fetch('stock.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(productosActualizados)
      });
      const data = await res.json();
      if (data.success) {
        stockModal.hide();
        alert('⟳ Stock actualizado correctamente.');
      } else {
        alert('❌ Error al actualizar stock.');
      }
    } catch (err) {
      console.error('Error en actualización:', err);
      alert('❌ Error de conexión al actualizar.');
    }
  });

});