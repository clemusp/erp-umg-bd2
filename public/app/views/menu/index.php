<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ERP - Menú Principal</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js" defer></script>
</head>
<body>
    <div class="menu-container">
        <button class="menu-button" onclick="navigateTo('contabilidad')">
            <img src="images/contabilidad.png" alt="Contabilidad">
            <span>Contabilidad</span>
        </button>
        <button class="menu-button" onclick="navigateTo('ventas')">
            <img src="images/ventas.png" alt="Ventas">
            <span>Ventas</span>
        </button>
        <button class="menu-button" onclick="navigateTo('inventario')">
            <img src="images/inventario.png" alt="Inventario">
            <span>Inventario</span>
        </button>
    </div>
</body>
</html>