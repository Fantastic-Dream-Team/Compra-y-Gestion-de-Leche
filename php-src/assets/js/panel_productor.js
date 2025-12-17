/* panel_productor.js */

// ===== MODAL ENTREGA =====
function abrirModalEntrega() {
    document.getElementById("modalEntrega").style.display = "flex";
}

function cerrarModalEntrega() {
    document.getElementById("modalEntrega").style.display = "none";
}

// ===== PANEL NOTIFICACIONES =====


function togglePanelNotificaciones() {
    document.getElementById("panel-notificaciones").classList.toggle("mostrar");
    document.getElementById("panel-alertas").classList.remove("mostrar");
}

function togglePanelAlertas() {
    document.getElementById("panel-alertas").classList.toggle("mostrar");
    document.getElementById("panel-notificaciones").classList.remove("mostrar");
}


// ===== FORMULARIO (PLACEHOLDER, SIN FUNCIONALIDAD REAL AÚN) =====
document.getElementById("formEntrega").addEventListener("submit", function(e) {
    e.preventDefault();
    alert("Entrega registrada exitosamente! (Funcionalidad placeholder)");
    cerrarModalEntrega();
});

// ===== GRÁFICAS PLACEHOLDER (USAR CHART.JS MÁS ADELANTE) =====
// Para ahora, solo canvas vacíos. Vincular a BD después.