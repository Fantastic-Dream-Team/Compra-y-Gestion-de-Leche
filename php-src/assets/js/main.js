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
    }, 5000);
  }

  // Activar autoplay en cada grupo de carrusel
  iniciarCarruselAuto("carrusel-vacas");
  iniciarCarruselAuto("carrusel-lab");
  iniciarCarruselAuto("carrusel-proceso");
  iniciarCarruselAuto("carrusel-productos");

  // ==========================
  // CARRUSEL: Etapas de Calidad (TRANSICIONES FLUIDAS)
  // ==========================
  const calidadSlidesContainer = document.querySelector('.calidad-slides-container');
  const calidadSlides = document.querySelectorAll('.calidad-carrusel-container .carrusel-slide');
  const calidadPrevBtn = document.querySelector('.calidad-carrusel-container .flecha-izq');
  const calidadNextBtn = document.querySelector('.calidad-carrusel-container .flecha-der');
  const calidadIndicators = document.querySelectorAll('.calidad-indicator');

  if (calidadSlides.length > 1) {
    let currentCalidadSlide = 0;
    const totalCalidadSlides = calidadSlides.length;
    let isTransitioning = false;
    const transitionDuration = 500; // ms
    
    function showCalidadSlide(slideIndex) {
      if (isTransitioning || slideIndex === currentCalidadSlide) return;
      
      isTransitioning = true;
      
      // Remover clase active de todos los slides
      calidadSlides.forEach(slide => slide.classList.remove('active'));
      
      // Actualizar indicadores
      calidadIndicators.forEach((indicator, index) => {
        if (index === slideIndex) {
          indicator.classList.add('active');
        } else {
          indicator.classList.remove('active');
        }
      });
      
      // Calcular la traslación
      const translateX = -slideIndex * 33.333 + '%';
      
      // Aplicar la transformación
      calidadSlidesContainer.style.transform = `translateX(${translateX})`;
      
      // Añadir clase active al slide actual después de un breve delay
      setTimeout(() => {
        calidadSlides[slideIndex].classList.add('active');
        currentCalidadSlide = slideIndex;
        isTransitioning = false;
      }, 50);
    }
    
    // Inicializar primer slide
    showCalidadSlide(0);
    
    // Event listeners para flechas
    if (calidadPrevBtn) {
      calidadPrevBtn.addEventListener('click', () => {
        const newSlide = currentCalidadSlide === 0 ? totalCalidadSlides - 1 : currentCalidadSlide - 1;
        showCalidadSlide(newSlide);
      });
    }
    
    if (calidadNextBtn) {
      calidadNextBtn.addEventListener('click', () => {
        const newSlide = currentCalidadSlide === totalCalidadSlides - 1 ? 0 : currentCalidadSlide + 1;
        showCalidadSlide(newSlide);
      });
    }
    
    // Event listeners para indicadores
    calidadIndicators.forEach((indicator, index) => {
      indicator.addEventListener('click', () => {
        showCalidadSlide(index);
      });
    });
    
    // Autoplay con efecto suave
    let calidadAutoplay = setInterval(() => {
      const newSlide = currentCalidadSlide === totalCalidadSlides - 1 ? 0 : currentCalidadSlide + 1;
      showCalidadSlide(newSlide);
    }, 8000);
    
    // Pausar autoplay al interactuar
    const calidadContainer = document.querySelector('.calidad-carrusel-container');
    if (calidadContainer) {
      calidadContainer.addEventListener('mouseenter', () => {
        clearInterval(calidadAutoplay);
      });
      
      calidadContainer.addEventListener('mouseleave', () => {
        calidadAutoplay = setInterval(() => {
          const newSlide = currentCalidadSlide === totalCalidadSlides - 1 ? 0 : currentCalidadSlide + 1;
          showCalidadSlide(newSlide);
        }, 8000);
      });
    }
    
    // Efectos de teclado (accesibilidad)
    document.addEventListener('keydown', (e) => {
      if (document.activeElement.closest('.calidad-carrusel-container')) {
        if (e.key === 'ArrowLeft') {
          const newSlide = currentCalidadSlide === 0 ? totalCalidadSlides - 1 : currentCalidadSlide - 1;
          showCalidadSlide(newSlide);
        } else if (e.key === 'ArrowRight') {
          const newSlide = currentCalidadSlide === totalCalidadSlides - 1 ? 0 : currentCalidadSlide + 1;
          showCalidadSlide(newSlide);
        }
      }
    });
  }



  // ==========================
  // CARRUSEL: Blog y Eventos (CORREGIDO - 6 POSTS EN 2 GRUPOS)
  // ==========================
  const blogSlideGroups = document.querySelectorAll('.blog-slide-group');
  const blogPrevBtn = document.querySelector('.carrusel-blog-container .flecha-izq');
  const blogNextBtn = document.querySelector('.carrusel-blog-container .flecha-der');
  const blogIndicators = document.querySelectorAll('.blog-indicator');
  const blogSlidesContainer = document.querySelector('.blog-slides-container');

  if (blogSlideGroups.length > 1) {
    let currentBlogGroup = 0;
    const totalGroups = blogSlideGroups.length;
    
    function showBlogGroup(groupIndex) {
      // Mover el contenedor
      const translateX = -groupIndex * 50 + '%'; // 50% por cada grupo
      blogSlidesContainer.style.transform = `translateX(${translateX})`;
      
      // Actualizar indicadores
      blogIndicators.forEach((indicator, index) => {
        if (index === groupIndex) {
          indicator.classList.add('active');
        } else {
          indicator.classList.remove('active');
        }
      });
      
      currentBlogGroup = groupIndex;
    }
    
    // Inicializar
    showBlogGroup(0);
    
    // Event listeners para flechas
    if (blogPrevBtn) {
      blogPrevBtn.addEventListener('click', () => {
        const newGroup = currentBlogGroup === 0 ? totalGroups - 1 : currentBlogGroup - 1;
        showBlogGroup(newGroup);
      });
    }
    
    if (blogNextBtn) {
      blogNextBtn.addEventListener('click', () => {
        const newGroup = currentBlogGroup === totalGroups - 1 ? 0 : currentBlogGroup + 1;
        showBlogGroup(newGroup);
      });
    }
    
    // Event listeners para indicadores
    blogIndicators.forEach((indicator, index) => {
      indicator.addEventListener('click', () => {
        showBlogGroup(index);
      });
    });
    
    // Autoplay
    let blogAutoplay = setInterval(() => {
      const newGroup = currentBlogGroup === totalGroups - 1 ? 0 : currentBlogGroup + 1;
      showBlogGroup(newGroup);
    }, 8000);
    
    // Pausar autoplay al interactuar
    const blogContainer = document.querySelector('.carrusel-blog-container');
    if (blogContainer) {
      blogContainer.addEventListener('mouseenter', () => {
        clearInterval(blogAutoplay);
      });
      
      blogContainer.addEventListener('mouseleave', () => {
        blogAutoplay = setInterval(() => {
          const newGroup = currentBlogGroup === totalGroups - 1 ? 0 : currentBlogGroup + 1;
          showBlogGroup(newGroup);
        }, 8000);
      });
    }
  }
});