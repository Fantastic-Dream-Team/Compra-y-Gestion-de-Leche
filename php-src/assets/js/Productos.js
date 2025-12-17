document.addEventListener('DOMContentLoaded', () => {
  // === SELECTORES ===
  const elements = {
    categories: document.getElementById('categories'),
    categoryBtns: document.querySelectorAll('.category-btn'),
    cards: document.querySelectorAll('.categoria'),
    searchInput: document.getElementById('search-input'),
    prevArrow: document.querySelector('.arrow.left'),
    nextArrow: document.querySelector('.arrow.right'),
    productosMain: document.querySelector('.productos-main')
  };

  // === ESTADO ===
  let filteredCategories = [...elements.cards];
  const originalCategoriesHTML = elements.categories.innerHTML;

  // === CARRUSEL DE CATEGORÍAS (STICKY) ===
  const updateArrows = () => {
    if (!elements.categories) return;
    const { scrollLeft, scrollWidth, clientWidth } = elements.categories;
    const maxScroll = scrollWidth - clientWidth;
    elements.prevArrow.disabled = scrollLeft <= 0;
    elements.nextArrow.disabled = scrollLeft >= maxScroll - 1;
  };

  const scrollCarousel = (direction) => {
    const amount = 120;
    const newPos = elements.categories.scrollLeft + (direction * amount);
    elements.categories.scrollTo({ left: newPos, behavior: 'smooth' });
  };

  elements.prevArrow?.addEventListener('click', () => scrollCarousel(-1));
  elements.nextArrow?.addEventListener('click', () => scrollCarousel(1));
  elements.categories?.addEventListener('scroll', updateArrows);

  // === FILTROS Y BÚSQUEDA ===
  const applyFilters = () => {
    const activeFilter = document.querySelector('.category-btn.active')?.dataset.filter || 'all';
    const term = elements.searchInput.value.toLowerCase().trim();

    if (term === '') {
      elements.categories.innerHTML = originalCategoriesHTML;
      elements.categoryBtns = document.querySelectorAll('.category-btn');
      elements.categoryBtns.forEach(btn => {
        btn.addEventListener('click', handleCategoryClick);
      });
      
      filteredCategories = [...elements.cards];
      filteredCategories.forEach(cat => cat.style.display = 'block');
    } else {
      elements.categories.innerHTML = '';
      
      const allProductos = document.querySelectorAll('.producto');
      allProductos.forEach(prod => {
        const title = prod.querySelector('.caja-titulo').textContent.toLowerCase();
        const desc = prod.querySelector('p').textContent.toLowerCase();
        
        if (title.includes(term) || desc.includes(term)) {
          const btn = document.createElement('button');
          btn.classList.add('category-btn');
          btn.textContent = prod.querySelector('.caja-titulo').textContent;
          btn.dataset.productId = prod.id;
          
          btn.addEventListener('click', () => {
            const target = document.getElementById(btn.dataset.productId);
            if (target) {
              target.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
              });
              
              target.style.transition = 'background 0.5s';
              target.style.background = '#fff3e0';
              setTimeout(() => { 
                target.style.background = ''; 
              }, 2000);
            }
          });
          
          elements.categories.appendChild(btn);
        }
      });
      
      filteredCategories.forEach(cat => {
        const productosEnCategoria = cat.querySelectorAll('.producto');
        let tieneCoincidencias = false;
        
        productosEnCategoria.forEach(prod => {
          const title = prod.querySelector('.caja-titulo').textContent.toLowerCase();
          const desc = prod.querySelector('p').textContent.toLowerCase();
          
          if (title.includes(term) || desc.includes(term)) {
            tieneCoincidencias = true;
          }
        });
        
        cat.style.display = tieneCoincidencias ? 'block' : 'none';
      });
    }
    
    updateArrows();
  };

  // === MANEJO DE CLIC EN CATEGORÍAS ===
  const handleCategoryClick = (e) => {
    const btn = e.currentTarget || e;
    const filter = btn.dataset.filter;
    
    elements.categoryBtns.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    
    if (filter === 'all') {
      filteredCategories.forEach(cat => {
        cat.style.display = 'block';
      });
      
      elements.productosMain.scrollIntoView({ 
        behavior: 'smooth' 
      });
    } else {
      filteredCategories.forEach(cat => {
        if (cat.dataset.type === filter) {
          cat.style.display = 'block';
          cat.scrollIntoView({ 
            behavior: 'smooth' 
          });
        } else {
          cat.style.display = 'none';
        }
      });
    }
    
    if (elements.searchInput.value.trim() !== '') {
      elements.searchInput.value = '';
      applyFilters();
    }
  };

  elements.categoryBtns.forEach(btn => {
    btn.addEventListener('click', handleCategoryClick);
  });

  elements.searchInput?.addEventListener('input', applyFilters);

  // === CARRUSELES DE PRODUCTOS ===
  const initializeProductCarousels = () => {
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

      actualizar();
    });
  };

  // === INICIALIZACIÓN SIMPLE ===
  const initialize = () => {
    updateArrows();
    initializeProductCarousels();
    window.addEventListener('resize', updateArrows);
  };

  initialize();
});