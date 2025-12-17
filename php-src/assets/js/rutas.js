document.addEventListener('DOMContentLoaded', function() {
    const itemsRuta = document.querySelectorAll('.ruta-item');
    const mapaImg = document.getElementById('mapa-ruta');

    // Obtenemos la ruta base desde el data-attribute del html
    const assetsPath = document.documentElement.dataset.assetsPath || '/Compra-y-Gestion-de-Leche/php-src/assets';
    console.log('Assets Path detectado:', assetsPath); // Para depuración

    // Datos de cada ruta (todas con la misma imagen)
    const rutas = {
        ruta1: {
            nombre: "Ruta Norte - Centro",
            info: "Cubre las zonas norte de David y alrededores. Entregas diarias de 5:00 a.m. a 11:00 a.m.",
            detalles: ["Frecuencia: Diaria", "Vehículos: 3 camiones refrigerados", "Productores: 12 fincas asociadas", "Horario: 5:00 AM - 11:00 AM"],
            imagen: `${assetsPath}/images/mapa-david.png`
        },
        ruta2: {
            nombre: "Ruta Este - Sur",
            info: "Atiende las comunidades del este de Chiriquí con entregas en horario vespertino.",
            detalles: ["Frecuencia: Lunes, Miércoles, Viernes", "Vehículos: 2 camiones refrigerados", "Productores: 8 fincas asociadas", "Horario: 2:00 PM - 6:00 PM"],
            imagen: `${assetsPath}/images/mapa-tierradeleche.png`
        },
        ruta3: {
            nombre: "Ruta Oeste - Rural",
            info: "Especial para zonas rurales y montañosas del oeste de la provincia.",
            detalles: ["Frecuencia: Martes y Jueves", "Vehículos: 1 camión 4x4 refrigerado", "Productores: 6 fincas asociadas", "Horario: 6:00 AM - 2:00 PM"],
            imagen: `${assetsPath}/images/mapa-finca.png`
        },
        ruta4: {
            nombre: "Ruta Express City",
            info: "Servicio express para centros urbanos con entregas rápidas y eficientes.",
            detalles: ["Frecuencia: Diaria (incluye sábados)", "Vehículos: 4 furgonetas refrigeradas", "Productores: 15 fincas asociadas", "Horario: 24/7 servicio prioritario"],
            imagen: `${assetsPath}/images/mapa-otrafinca.png`
        }
    };

    // Función para cambiar ruta
    function cambiarRuta(rutaId) {
        console.log('Cambiando a ruta:', rutaId);
        
        const ruta = rutas[rutaId];
        
        if (!ruta) {
            console.error('Ruta no encontrada:', rutaId);
            return;
        }
        
        // Remover clase 'activo' de todos los items
        itemsRuta.forEach(item => {
            item.classList.remove('activo');
        });
        
        // Agregar clase 'activo' al item clickeado
        const itemActivo = document.querySelector(`.ruta-item[data-ruta="${rutaId}"]`);
        if (itemActivo) {
            itemActivo.classList.add('activo');
        }
        
        // Actualizar información de la ruta
        const titulo = document.getElementById('ruta-titulo');
        const descripcion = document.getElementById('ruta-descripcion');
        const detalles = document.getElementById('ruta-detalles');
        
        if (titulo) titulo.textContent = ruta.nombre;
        if (descripcion) descripcion.textContent = ruta.info;
        
        // Actualizar lista de detalles
        if (detalles) {
            detalles.innerHTML = '';
            ruta.detalles.forEach(detalle => {
                const li = document.createElement('li');
                li.textContent = detalle;
                detalles.appendChild(li);
            });
        }
        
        // Actualizar imagen (misma para todas, pero por si acaso)
        if (mapaImg) {
            // Verificar que la imagen existe antes de cambiar
            const imgTest = new Image();
            imgTest.onload = function() {
                mapaImg.src = ruta.imagen;
                mapaImg.alt = `Mapa de Rutas - ${ruta.nombre}`;
                console.log('Imagen cargada correctamente:', ruta.imagen);
            };
            imgTest.onerror = function() {
                console.error('No se pudo cargar la imagen:', ruta.imagen);
                // Intentar una ruta alternativa
                const fallbackPath = assetsPath ? `${assetsPath}/images/mapa-david.png` : '/assets/images/mapa-david.png';
                mapaImg.src = fallbackPath;
                mapaImg.alt = `Mapa de Rutas - ${ruta.nombre}`;
            };
            imgTest.src = ruta.imagen;
        }
    }

    // Agregar event listeners a los items de ruta
    itemsRuta.forEach(item => {
        item.addEventListener('click', function() {
            const rutaId = this.getAttribute('data-ruta');
            cambiarRuta(rutaId);
        });
    });

    // Configurar ruta inicial
    cambiarRuta('ruta1');
    
    console.log('Sistema de rutas estático inicializado correctamente');
});