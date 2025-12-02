document.addEventListener('DOMContentLoaded', () => {
  const track = document.querySelector('.track-final');
  const slides = document.querySelectorAll('.slide-final');
  const izq = document.querySelector('.flecha-izq');
  const der = document.querySelector('.flecha-der');
  const puntos = document.querySelectorAll('.punto');
  
  // Verificar que existan elementos antes de continuar
  if (!track || !slides.length || !izq || !der) {
    console.log('No hay elementos de carrusel disponibles');
    return;
  }

  let i = 0;

  const mover = () => {
    track.style.transform = `translateX(-${i * 100}%)`;
    actualizarPuntos();
  };

  const actualizarPuntos = () => {
    puntos.forEach((p, idx) => {
      p.classList.toggle('activo', idx === i);
    });
  };

  // Botón derecha
  der.addEventListener('click', () => {
    i = (i + 1) % slides.length;
    mover();
  });

  // Botón izquierda
  izq.addEventListener('click', () => {
    i = (i - 1 + slides.length) % slides.length;
    mover();
  });

  // Click en puntos
  puntos.forEach((p, idx) => {
    p.addEventListener('click', () => {
      i = idx;
      mover();
    });
  });

  // Auto-avance cada 7 segundos
  let autoplayInterval = setInterval(() => {
    i = (i + 1) % slides.length;
    mover();
  }, 7000);

  // Pausar autoplay al hover
  const carruselContainer = document.querySelector('.carrusel-productores-final');
  if (carruselContainer) {
    carruselContainer.addEventListener('mouseenter', () => {
      clearInterval(autoplayInterval);
    });

    carruselContainer.addEventListener('mouseleave', () => {
      autoplayInterval = setInterval(() => {
        i = (i + 1) % slides.length;
        mover();
      }, 7000);
    });
  }

  // Inicializar
  mover();
});