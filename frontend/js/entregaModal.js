document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById("modalEntrega");  
    const btnAbrir = document.querySelector(".btn-registrar-entrega");
    const btnCerrar = document.querySelector(".cerrar");

    if (!modal || !btnAbrir) {
        console.warn('Modal o botón no encontrados');
        return;
    }

    btnAbrir.onclick = () => modal.style.display = "block";
    btnCerrar.onclick = () => modal.style.display = "none";
    window.onclick = (e) => {
        if (e.target === modal) modal.style.display = "none";
    };
});