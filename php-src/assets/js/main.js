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
  // CARRUSEL: Etapas de Control de Calidad
  // ==========================
  const slides = document.querySelectorAll(".etapas-control-calidad .carrusel-slide");
  const prev = document.querySelector(".etapas-control-calidad .flecha-izq");
  const next = document.querySelector(".etapas-control-calidad .flecha-der");
  let currentSlide = 0;

  if (slides.length > 1) {
    function mostrarSlide(index) {
      slides.forEach((slide, i) => {
        slide.style.display = i === index ? "flex" : "none";
      });
    }

    mostrarSlide(currentSlide);

    prev?.addEventListener("click", () => {
      currentSlide = (currentSlide - 1 + slides.length) % slides.length;
      mostrarSlide(currentSlide);
    });

    next?.addEventListener("click", () => {
      currentSlide = (currentSlide + 1) % slides.length;
      mostrarSlide(currentSlide);
    });
  }

// ==========================
// CARRUSEL: Blog y Eventos
// ==========================
const blogPosts = document.querySelectorAll(".carrusel-blog .post");
const blogPrev = document.querySelector(".carrusel-blog .flecha-izq");
const blogNext = document.querySelector(".carrusel-blog .flecha-der");
let currentPost = 0;

// Mostrar SIEMPRE las tres primeras
if (blogPosts.length > 0) {
  function mostrarPost(index) {
    blogPosts.forEach((post, i) => {
      // Mostrar 3 a la vez
      if (i >= index && i < index + 3) {
        post.style.display = "block";
      } else {
        post.style.display = "none";
      }
    });
  }

  mostrarPost(currentPost);

  blogPrev?.addEventListener("click", () => {
    currentPost = (currentPost - 1 + blogPosts.length) % blogPosts.length;
    mostrarPost(currentPost);
  });

  blogNext?.addEventListener("click", () => {
    currentPost = (currentPost + 1) % blogPosts.length;
    mostrarPost(currentPost);
  });
}

});
