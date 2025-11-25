document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.carrusel').forEach(carrusel => {
    const contenedor = carrusel.querySelector('.contenedor-productos');
    const productos = contenedor.children;
    const total = productos.length;
    const visibles = 3;
    let indice = 0;

    const actualizar = () => {
      const offset = -indice * (100 / visibles);
      contenedor.style.transform = `translateX(${offset}%)`;
      
      carrusel.querySelector('.izquierda').disabled = indice === 0;
      carrusel.querySelector('.derecha').disabled = indice >= total - visibles;
    };

    carrusel.querySelector('.izquierda').addEventListener('click', () => {
      if (indice > 0) {
        indice--;
        actualizar();
      }
    });

    carrusel.querySelector('.derecha').addEventListener('click', () => {
      if (indice < total - visibles) {
        indice++;
        actualizar();
      }
    });

    actualizar(); // inicial
  });
});