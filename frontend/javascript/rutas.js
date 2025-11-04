document.addEventListener('DOMContentLoaded', function() {
  
  // ===== TOGGLE PANEL LATERAL =====
  const headerPanel = document.querySelector('.header-panel');
  const contenidoPanel = document.querySelector('.contenido-panel');
  const iconoFlecha = document.querySelector('.icono-flecha');
  
  headerPanel.addEventListener('click', function() {
    if (contenidoPanel.style.maxHeight && contenidoPanel.style.maxHeight !== '0px') {

      contenidoPanel.style.maxHeight = '0';
      contenidoPanel.style.padding = '0 20px';
      iconoFlecha.classList.remove('rotado');
    } else {

      contenidoPanel.style.maxHeight = contenidoPanel.scrollHeight + 40 + 'px';
      contenidoPanel.style.padding = '20px';
      iconoFlecha.classList.add('rotado');
    }
  });
  
  
  // ===== TOGGLE DROPDOWN DE RUTAS =====
  const btnDropdown = document.querySelector('.btn-dropdown');
  const listaItems = document.querySelector('.lista-items-ruta');
  const iconoDropdown = document.querySelector('.icono-dropdown');
  
  btnDropdown.addEventListener('click', function() {
    if (listaItems.style.maxHeight && listaItems.style.maxHeight !== '0px') {

      listaItems.style.maxHeight = '0';
      iconoDropdown.classList.remove('rotado');
    } else {

      listaItems.style.maxHeight = listaItems.scrollHeight + 'px';
      iconoDropdown.classList.add('rotado');
    }
  });
  
  
  // ===== SELECCIONAR RUTA =====
  const itemsRuta = document.querySelectorAll('.item-ruta');
  const infoRutaSeleccionada = document.querySelector('.info-ruta-seleccionada');
  const rutasInfo = {
    'ruta1': 'Información detallada de la Ruta 1: Cubre las zonas norte de la ciudad, pasando por los sectores A, B y C.',
    'ruta2': 'Información detallada de la Ruta 2: Abarca el área central y este, incluyendo puntos de distribución principales.',
    'ruta3': 'Información detallada de la Ruta 3: Zona sur y oeste, con cobertura en áreas rurales y urbanas.'
  };
  
  itemsRuta.forEach(item => {
    item.addEventListener('click', function() {

      itemsRuta.forEach(i => i.classList.remove('activo'));
      
      this.classList.add('activo');
      
      const rutaId = this.getAttribute('data-ruta');
      const nombreRuta = this.textContent;

      if (rutasInfo[rutaId]) {
        infoRutaSeleccionada.innerHTML = `
          <h3>Información de ${nombreRuta}</h3>
          <p>${rutasInfo[rutaId]}</p>
        `;
      } else {
        infoRutaSeleccionada.innerHTML = `
          <h3>Información de ${nombreRuta}</h3>
          <p>Información no disponible para esta ruta.</p>
        `;
      }
      
      btnDropdown.querySelector('span:first-child').textContent = nombreRuta;
      
      // Cerrar el dropdown
      listaItems.style.maxHeight = '0';
      iconoDropdown.classList.remove('rotado');
      
      // Aquí llamarías la función para actualizar el mapa
      console.log('Ruta seleccionada:', rutaId, nombreRuta);
      // actualizarMapa(rutaId); // Función que crearás más adelante
    });
  });

  let mapa;
let marcadores = [];

function inicializarMapa() {

  mapa = L.map('mapa-rutas').setView([9.145, -79.451], 12);
  
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(mapa);
  
  document.getElementById('mapa-rutas').classList.add('mapa-cargado');
}

function actualizarMapa(rutaId) {

  marcadores.forEach(m => mapa.removeLayer(m));
  marcadores = [];
  
  const rutas = {
    'ruta1': {
      puntos: [[9.145, -79.451], [9.155, -79.461]],
      color: 'blue'
    },
    'ruta2': {
      puntos: [[9.135, -79.441], [9.145, -79.431]],
      color: 'orange'
    },
    'ruta3': {
      puntos: [[9.125, -79.471], [9.135, -79.461]],
      color: 'red'
    }
  };
  
  if (rutas[rutaId]) {
    const ruta = rutas[rutaId];
    
    const polyline = L.polyline(ruta.puntos, {color: ruta.color}).addTo(mapa);
    marcadores.push(polyline);
    
    mapa.fitBounds(polyline.getBounds());
  }
}


document.addEventListener('DOMContentLoaded', inicializarMapa);

  
});