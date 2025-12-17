document.addEventListener('DOMContentLoaded', function() {
  
  // Elementos
  const headerPanel = document.querySelector('.header-panel');
  const contenidoPanel = document.querySelector('.contenido-panel');
  const iconoFlecha = document.querySelector('.icono-flecha');
  const btnDropdown = document.querySelector('.btn-dropdown');
  const listaItems = document.querySelector('.lista-items-ruta');
  const iconoDropdown = document.querySelector('.icono-dropdown');
  const itemsRuta = document.querySelectorAll('.item-ruta');
  const infoRuta = document.querySelector('.info-ruta-seleccionada');
  const iframeMap = document.getElementById('google-map');

  // Datos de rutas
  const rutas = {
    ruta1: {
      nombre: "Ruta Norte - Centro",
      info: "Cubre las zonas norte de la ciudad, pasando por los sectores A, B y C. Entregas diarias de 6:00 a.m. a 12:00 p.m.",
      mapa: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3920.463!2d-79.534!3d8.948!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOcKwNTYnNTIuOCJOIDc5wrAzMScwMC4wIlc!5e0!3m2!1ses!2spa!4v1733950000000!5m2!1ses!2spa",
      detalles: ["Frecuencia: Diaria", "Vehículos: 3 camiones refrigerados", "Productores: 12 fincas asociadas"]
    },
    ruta2: {
      nombre: "Ruta Este - Sur",
      info: "Recorre el área central y este, incluyendo puntos de distribución principales. Servicio de lunes a sábado.",
      mapa: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d980.2!2d-79.510!3d8.970!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOcKwNTggMTIuMCJOIDc5wrAzMCDigKIwLjAiVyc!5e0!3m2!1ses!2spa!4v1733951000000!5m2!1ses!2spa",
      detalles: ["Frecuencia: 6 días", "Vehículos: 2 camiones", "Productores: 8 fincas"]
    },
    ruta3: {
      nombre: "Ruta Oeste - Rural",
      info: "Zona sur y oeste, con cobertura en áreas rurales y urbanas. Enfocada en fincas grandes.",
      mapa: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d490.5!2d-79.550!3d8.930!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOcKwNTUgNDguMCJOIDc5wrAzMycwMC4wIlc!5e0!3m2!1ses!2spa!4v1733952000000!5m2!1ses!2spa",
      detalles: ["Frecuencia: 5 días", "Vehículos: 4 camiones", "Productores: 15 fincas"]
    },
    ruta4: {
      nombre: "Ruta Express City",
      info: "Servicio premium para supermercados y restaurantes en el centro. Entregas en 2 horas.",
      mapa: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1225.8!2d-79.520!3d8.960!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOcKwNTcgMzYuMCJOIDc5wrAzMScxMi4wIlc!5e0!3m2!1ses!2spa!4v1733953000000!5m2!1ses!2spa",
      detalles: ["Frecuencia: Bajo demanda", "Vehículos: 1 furgoneta", "Productores: 5 exclusivos"]
    }
  };

  // Abrir/cerrar panel
  headerPanel.addEventListener('click', () => {
    const estaAbierto = contenidoPanel.classList.contains('abierto');
    contenidoPanel.classList.toggle('abierto');
    iconoFlecha.classList.toggle('rotado');
    
    if (estaAbierto) {
      contenidoPanel.style.maxHeight = '0';
    } else {
      contenidoPanel.style.maxHeight = contenidoPanel.scrollHeight + 40 + 'px';
    }
  });

  // Dropdown
  btnDropdown.addEventListener('click', () => {
    listaItems.classList.toggle('abierto');
    iconoDropdown.classList.toggle('rotado');
  });

  // Seleccionar ruta
  itemsRuta.forEach(item => {
    item.addEventListener('click', function() {
      const rutaId = this.getAttribute('data-ruta');
      const ruta = rutas[rutaId];

      // Actualizar botón
      btnDropdown.querySelector('span:first-child').textContent = ruta.nombre;
      btnDropdown.classList.add('activo');

      // Actualizar info
      infoRuta.innerHTML = `
        <h3>${ruta.nombre}</h3>
        <p>${ruta.info}</p>
        <ul>
          ${ruta.detalles.map(d => `<li>${d}</li>`).join('')}
        </ul>
      `;

      // Actualizar mapa
      iframeMap.src = ruta.mapa;

      // Cerrar dropdown
      listaItems.classList.remove('abierto');
      iconoDropdown.classList.remove('rotado');

      // Resaltar item
      itemsRuta.forEach(i => i.classList.remove('activo'));
      this.classList.add('activo');
    });
  });

  // Abrir panel por defecto en desktop
  if (window.innerWidth > 992) {
    contenidoPanel.classList.add('abierto');
    contenidoPanel.style.maxHeight = contenidoPanel.scrollHeight + 40 + 'px';
    iconoFlecha.classList.add('rotado');
  }
});