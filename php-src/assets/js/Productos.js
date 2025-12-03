document.addEventListener('DOMContentLoaded', () => {
  // === SELECTORES COMUNES ===
  const categoriesContainer = document.getElementById('categories');
  const searchInput = document.getElementById('search-input');
  const leftArrow = document.querySelector('.arrow.left');
  const rightArrow = document.querySelector('.arrow.right');

  // Guardar HTML original de categorías para restaurar
  const originalCategoriesHTML = categoriesContainer.innerHTML;

  // === CARRUSEL DE CATEGORÍAS/BÚSQUEDA (con flechas) ===
  const updateArrows = () => {
    const scrollLeft = categoriesContainer.scrollLeft;
    const maxScroll = categoriesContainer.scrollWidth - categoriesContainer.clientWidth;
    leftArrow.disabled = scrollLeft <= 0;
    rightArrow.disabled = scrollLeft >= maxScroll - 1;
  };

  leftArrow.addEventListener('click', () => {
    categoriesContainer.scrollBy({ left: -120, behavior: 'smooth' });
    updateArrows();
  });

  rightArrow.addEventListener('click', () => {
    categoriesContainer.scrollBy({ left: 120, behavior: 'smooth' });
    updateArrows();
  });

  categoriesContainer.addEventListener('scroll', updateArrows);
  window.addEventListener('resize', updateArrows);

  // Función para manejar click en botones de categorías
  const handleCategoryClick = (btn) => {
    const filter = btn.dataset.filter;
    const target = filter === 'all' 
      ? document.querySelector('.productos-main') 
      : document.querySelector(`.categoria[data-type="${filter}"]`);
    if (target) {
      target.scrollIntoView({ behavior: 'smooth' });
    }
  };

  // Añadir listeners a botones iniciales
  document.querySelectorAll('.category-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      handleCategoryClick(btn);
    });
  });

  // === BÚSQUEDA: Modifica el carrusel en tiempo real ===
  searchInput.addEventListener('input', () => {
    const term = searchInput.value.toLowerCase().trim();

    if (term === '') {
      // Restaurar categorías originales
      categoriesContainer.innerHTML = originalCategoriesHTML;
      // Reañadir listeners a los nuevos botones
      categoriesContainer.querySelectorAll('.category-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          categoriesContainer.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          handleCategoryClick(btn);
        });
      });
    } else {
      // Limpiar y mostrar productos coincidentes como botones
      categoriesContainer.innerHTML = '';
      const allProductos = document.querySelectorAll('.producto');
      allProductos.forEach(prod => {
        const title = prod.querySelector('.caja-titulo').textContent.toLowerCase();
        const desc = prod.querySelector('p').textContent.toLowerCase();
        if (title.includes(term) || desc.includes(term)) {
          const btn = document.createElement('button');
          btn.classList.add('category-btn');
          btn.textContent = prod.querySelector('.caja-titulo').textContent;
          btn.dataset.productId = prod.id; // ID del producto para scroll
          btn.addEventListener('click', () => {
            const target = document.getElementById(btn.dataset.productId);
            if (target) {
              target.scrollIntoView({ behavior: 'smooth', block: 'center' });
              // Opcional: highlight temporal
              target.style.transition = 'background 0.5s';
              target.style.background = '#fff3e0';
              setTimeout(() => { target.style.background = ''; }, 2000);
            }
          });
          categoriesContainer.appendChild(btn);
        }
      });
    }
    updateArrows();
  });

  // === CARRUSELES DE PRODUCTOS POR SECCIÓN (ya existente, sin cambios) ===
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

    actualizar(); // Inicial
  });

  // Inicialización
  updateArrows();
});