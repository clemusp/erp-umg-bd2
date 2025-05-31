document.addEventListener('DOMContentLoaded', () => {
    const btnAgregar = document.getElementById('btnAgregarLineaComp');
    const btnGuardar = document.getElementById('btnGuardarComp');
    const tbody = document.querySelector('#tablaComprobante tbody');
    const totalDebeCell = document.getElementById('totalDebe');
    const totalHaberCell = document.getElementById('totalHaber');
    const respuesta = document.getElementById('respuestaContabilidad');
  
    btnAgregar.addEventListener('click', (e) => {
      e.preventDefault();
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>
          <select class="form-select cuenta">
            <option value="">-- Seleccionar --</option>
          </select>
        </td>
        <td><input type="text" class="form-control descLinea" placeholder="Descripción"></td>
        <td><input type="number" class="form-control debe" step="0.01" value="0"></td>
        <td><input type="number" class="form-control haber" step="0.01" value="0"></td>
        <td><button class="btn btn-danger btn-sm eliminar">X</button></td>
      `;
      tbody.appendChild(row);
      agregarEventosLinea(row);
    });
  
    btnGuardar.addEventListener('click', (e) => {
      e.preventDefault();
      // Validar balances
      const debe = parseFloat(totalDebeCell.textContent) || 0;
      const haber = parseFloat(totalHaberCell.textContent) || 0;
      if (debe !== haber) {
        respuesta.textContent = 'El comprobante debe estar balanceado (Debe = Haber).';
        return;
      }
      respuesta.textContent = 'Comprobante válido (simulado).';
      // TODO: enviar datos al backend
    });
  
    function agregarEventosLinea(row) {
      const debeInput = row.querySelector('.debe');
      const haberInput = row.querySelector('.haber');
      const btnEliminar = row.querySelector('.eliminar');
  
      function recalcular() {
        const debeValues = Array.from(document.querySelectorAll('.debe')).map(i => parseFloat(i.value) || 0);
        const haberValues = Array.from(document.querySelectorAll('.haber')).map(i => parseFloat(i.value) || 0);
        const totalDebe = debeValues.reduce((a,b) => a+b,0);
        const totalHaber = haberValues.reduce((a,b) => a+b,0);
        totalDebeCell.textContent = totalDebe.toFixed(2);
        totalHaberCell.textContent = totalHaber.toFixed(2);
      }
  
      debeInput.addEventListener('input', () => {
        haberInput.value = 0;
        recalcular();
      });
      haberInput.addEventListener('input', () => {
        debeInput.value = 0;
        recalcular();
      });
      btnEliminar.addEventListener('click', (ev) => {
        ev.preventDefault(); row.remove(); recalcular();
      });
    }
  });