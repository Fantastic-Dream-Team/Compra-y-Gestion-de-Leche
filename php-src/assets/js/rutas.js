document.addEventListener('DOMContentLoaded', function() {
    const headerPanel = document.querySelector('.header-panel');
    const contenidoPanel = document.querySelector('.contenido-panel');
    const iconoFlecha = document.querySelector('.icono-flecha');
    const btnDropdown = document.querySelector('.btn-dropdown');
    const listaItems = document.querySelector('.lista-items-ruta');
    const iconoDropdown = document.querySelector('.icono-dropdown');
    const itemsRuta = document.querySelectorAll('.item-ruta');
    const infoRuta = document.querySelector('.info-ruta-seleccionada');
    const mapaImg = document.getElementById('mapa-ruta');

    // Obtenemos la ruta base desde un data-attribute que pondremos en el HTML
    const assetsPath = document.documentElement.getAttribute('data-assets-path') || '/assets';

    // Datos de cada ruta (ahora usamos la variable assetsPath)
    const rutas = {
        ruta1: {
            nombre: "Ruta Norte - Centro",
            info: "Cubre las zonas norte de David y alrededores. Entregas diarias de 5:00 a.m. a 11:00 a.m.",
            detalles: ["Frecuencia: Diaria", "Vehículos: 3 camiones refrigerados", "Productores: 12 fincas asociadas"],
            imagen: `${assetsPath}/images/mapa_david.jpg`
        },
        ruta2: {
            nombre: "Ruta Este - Sur",
            info: "Recorre Boquerón, Dolega y zonas aledañas. Servicio de lunes a sábado.",
            detalles: ["Frecuencia: 6 días", "Vehículos: 2 camiones", "Productores: 8 fincas"],
            imagen: `${assetsPath}/images/mapa_david.jpg`
        },
        ruta3: {
            nombre: "Ruta Oeste - Rural",
            info: "Zona de Alanje, Bugaba y áreas rurales extensas.",
            detalles: ["Frecuencia: 5 días", "Vehículos: 4 camiones", "Productores: 15 fincas"],
            imagen: `${assetsPath}/images/mapa_david.jpg`
        },
        ruta4: {
            nombre: "Ruta Express City",
            info: "Entregas rápidas en David centro para supermercados y restaurantes.",
            detalles: ["Frecuencia: Bajo demanda", "Vehículos: 1 furgoneta", "Productores: 5 exclusivos"],
            imagen: `${assetsPath}/images/mapa_david.jpg`
        }
    };

    // Abrir/cerrar panel lateral
    headerPanel?.addEventListener('click', () => {
        contenidoPanel.classList.toggle('abierto');
        iconoFlecha.classList.toggle('rotado');
        if (contenidoPanel.classList.contains('abierto')) {
            contenidoPanel.style.maxHeight = contenidoPanel.scrollHeight + 50 + 'px';
        } else {
            contenidoPanel.style.maxHeight = '0';
        }
    });

    // Dropdown
    btnDropdown?.addEventListener('click', () => {
        listaItems.classList.toggle('abierto');
        iconoDropdown.classList.toggle('rotado');
    });

    // Cambiar ruta
    itemsRuta.forEach(item => {
        item.addEventListener('click', function() {
            const rutaId = this.getAttribute('data-ruta');
            const ruta = rutas[rutaId];

            btnDropdown.querySelector('span:first-child').textContent = ruta.nombre;

            infoRuta.innerHTML = `
                <h3>${ruta.nombre}</h3>
                <p>${ruta.info}</p>
                <ul>
                    ${ruta.detalles.map(d => `<li>${d}</li>`).join('')}
                </ul>
            `;

            mapaImg.src = ruta.imagen;

            listaItems.classList.remove('abierto');
            iconoDropdown.classList.remove('rotado');
            itemsRuta.forEach(i => i.classList.remove('activo'));
            this.classList.add('activo');
        });
    });

    // Abrir panel por defecto en desktop
    if (window.innerWidth > 992) {
        contenidoPanel.classList.add('abierto');
        contenidoPanel.style.maxHeight = contenidoPanel.scrollHeight + 50 + 'px';
        iconoFlecha.classList.add('rotado');
    }
});
