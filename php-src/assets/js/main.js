// ====== Esperar a que el DOM esté listo ======
document.addEventListener("DOMContentLoaded", () => {
  console.log("✅ JS de Don Joaquín cargado correctamente");

  // ==========================
  // CARRUSELES AUTOMÁTICOS EN "NUESTRO ENTORNO"
  // ==========================
  function iniciarCarruselAuto(nombreGrupo) {
    const radios = document.querySelectorAll(`input[name="${nombreGrupo}"]`);
    if (radios.length === 0) return;

    let index = 0;
    setInterval(() => {
      radios[index].checked = false;
      index = (index + 1) % radios.length;
      radios[index].checked = true;
    }, 5000); // Cambia cada 5 segundos
  }

  // Activar autoplay en cada grupo de carrusel
  iniciarCarruselAuto("carrusel-vacas");
  iniciarCarruselAuto("carrusel-lab");
  iniciarCarruselAuto("carrusel-proceso");
  iniciarCarruselAuto("carrusel-productos");

 // ==========================
// CARRUSEL CONTROL DE CALIDAD
// ==========================
const slidesContainer = document.querySelector(
  ".etapas-control-calidad .carrusel-slides"
);
const slides = document.querySelectorAll(
  ".etapas-control-calidad .carrusel-slide"
);
const prev = document.querySelector(".etapas-control-calidad .flecha-izq");
const next = document.querySelector(".etapas-control-calidad .flecha-der");

let currentSlide = 0;

function mostrarSlide(index) {
  slidesContainer.style.transform = `translateX(-${index * 100}%)`;
}

prev.addEventListener("click", () => {
  currentSlide = (currentSlide - 1 + slides.length) % slides.length;
  mostrarSlide(currentSlide);
});

next.addEventListener("click", () => {
  currentSlide = (currentSlide + 1) % slides.length;
  mostrarSlide(currentSlide);
});

// ==========================
// CARRUSEL: Blog y Eventos (muestra 3 a la vez, desliza en grupos de 3)
// ==========================
const blogContainer = document.querySelector(".carrusel-blog .blog");
const blogPosts = document.querySelectorAll(".carrusel-blog .post");
const blogPrev = document.querySelector(".carrusel-blog .flecha-izq");
const blogNext = document.querySelector(".carrusel-blog .flecha-der");
let currentPost = 0;
const postsPerView = 3;  // Número de posts visibles
const step = 3;          // Deslizar de 3 en 3

if (blogPosts.length > 0 && blogContainer) {
  function mostrarPost(index) {
    // Ajustar índice para ciclo
    index = index % blogPosts.length;
    if (index < 0) index += blogPosts.length;
    
    // Deslizar el contenedor
    blogContainer.style.transform = `translateX(-${index * (100 / postsPerView)}%)`;
  }

  // Inicializar
  mostrarPost(currentPost);

  blogPrev?.addEventListener("click", () => {
    currentPost -= step;
    mostrarPost(currentPost);
  });

  blogNext?.addEventListener("click", () => {
    currentPost += step;
    mostrarPost(currentPost);
  });
}

});
