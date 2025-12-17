document.addEventListener('DOMContentLoaded', () => {
  const track = document.querySelector('.track-final');
  const slides = document.querySelectorAll('.slide-final');
  const izq = document.querySelector('.flecha-izq');
  const der = document.querySelector('.flecha-der');
  let i = 0;

  const mover = () => {
    track.style.transform = `translateX(-${i * 100}%)`;
  };

  der.addEventListener('click', () => {
    i = (i + 1) % slides.length;
    mover();
  });

  izq.addEventListener('click', () => {
    i = (i - 1 + slides.length) % slides.length;
    mover();
  });

  // Auto cada 7 segundos
  setInterval(() => {
    i = (i + 1) % slides.length;
    mover();
  }, 7000);

  mover();

  const puntos = document.querySelectorAll('.punto');
  puntos.forEach((p, idx) => {
    p.addEventListener('click', () => {
      i = idx;
      mover();
      actualizarPuntos();
    });
  });

  function actualizarPuntos() {
    puntos.forEach((p, idx) => {
      p.classList.toggle('activo', idx === i);
    });
  }
  
  mover();
  actualizarPuntos();
  setInterval(() => { i = (i + 1) % slides.length; mover(); actualizarPuntos(); }, 7000);

});