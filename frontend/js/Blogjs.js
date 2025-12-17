/**
 * Blog.js - Funcionalidad del blog: filtros, búsqueda, paginación y carrusel
 * Optimizado para rendimiento y claridad
 */

document.addEventListener('DOMContentLoaded', () => {
  // === ELEMENTOS DEL DOM ===
  const categoriesContainer = document.getElementById('categories');
  const categoryBtns = document.querySelectorAll('.category-btn');
  const cards = document.querySelectorAll('.card');
  const searchInput = document.getElementById('search-input');
  const prevBtn = document.querySelector('.arrow.left');
  const nextBtn = document.querySelector('.arrow.right');
  const prevPageBtn = document.getElementById('prev-page');
  const nextPageBtn = document.getElementById('next-page');
  const pageNumbersContainer = document.getElementById('page-numbers');

  // === ESTADO ===
  let currentPage = 1;
  const postsPerPage = 9;
  let filteredCards = Array.from(cards);
  let scrollPosition = 0;
  const scrollAmount = 120;

  // === CARRUSEL DE CATEGORÍAS ===
  const updateCarouselArrows = () => {
    if (!categoriesContainer || !prevBtn || !nextBtn) return;
    // sincroniza scrollPosition con el estado real por si el usuario hace scroll manual
    scrollPosition = categoriesContainer.scrollLeft;
    const maxScroll = Math.max(0, categoriesContainer.scrollWidth - categoriesContainer.clientWidth);
    prevBtn.disabled = scrollPosition === 0;
    nextBtn.disabled = scrollPosition >= maxScroll - 1; // -1 para tolerancia de subpixel
  };

  if (nextBtn && categoriesContainer) {
    nextBtn.addEventListener('click', () => {
      const maxScroll = Math.max(0, categoriesContainer.scrollWidth - categoriesContainer.clientWidth);
      scrollPosition = Math.min(categoriesContainer.scrollLeft + scrollAmount, maxScroll);
      categoriesContainer.scrollTo({ left: scrollPosition, behavior: 'smooth' });
      // actualizar después de un pequeño delay para reflejar el scroll (pero también sincronizamos al inicio)
      setTimeout(updateCarouselArrows, 200);
    });
  }

  if (prevBtn && categoriesContainer) {
    prevBtn.addEventListener('click', () => {
      scrollPosition = Math.max(categoriesContainer.scrollLeft - scrollAmount, 0);
      categoriesContainer.scrollTo({ left: scrollPosition, behavior: 'smooth' });
      setTimeout(updateCarouselArrows, 200);
    });
  }

  // sincronizar si el usuario hace scroll manual con el mouse o touch
  if (categoriesContainer) {
    categoriesContainer.addEventListener('scroll', () => {
      scrollPosition = categoriesContainer.scrollLeft;
      updateCarouselArrows();
    });
  }

  // === FILTROS Y BÚSQUEDA ===
  const filterPosts = () => {
    const activeFilter = document.querySelector('.category-btn.active')?.dataset?.filter || 'all';
    const searchTerm = (searchInput?.value || '').toLowerCase().trim();

    filteredCards = Array.from(cards).filter(card => {
      const type = card.dataset?.type || '';
      const titleEl = card.querySelector('h3');
      const excerptEl = card.querySelector('p');
      const title = titleEl ? titleEl.textContent.toLowerCase() : '';
      const excerpt = excerptEl ? excerptEl.textContent.toLowerCase() : '';

      const matchesFilter = activeFilter === 'all' || type === activeFilter;
      const matchesSearch = !searchTerm || title.includes(searchTerm) || excerpt.includes(searchTerm);

      return matchesFilter && matchesSearch;
    });

    currentPage = 1;
    renderPosts();
    renderPagination();
    updateCarouselArrows();
  };

  // Activar botón de categoría
  if (categoryBtns && categoryBtns.length) {
    categoryBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        categoryBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        filterPosts();
      });
    });
  }

  if (searchInput) {
    searchInput.addEventListener('input', filterPosts);
  }

  // === RENDERIZADO DE POSTS ===
  const renderPosts = () => {
    // ocultar todas
    cards.forEach(card => (card.style.display = 'none'));

    if (!filteredCards.length) return;

    const start = (currentPage - 1) * postsPerPage;
    const end = start + postsPerPage;
    filteredCards.slice(start, end).forEach(card => (card.style.display = 'block'));
  };

  // === PAGINACIÓN ===
  const renderPagination = () => {
    if (!pageNumbersContainer || !prevPageBtn || !nextPageBtn) return;

    const totalPages = Math.max(1, Math.ceil(filteredCards.length / postsPerPage));
    pageNumbersContainer.innerHTML = '';

    prevPageBtn.disabled = currentPage === 1;
    nextPageBtn.disabled = currentPage === totalPages;

    for (let i = 1; i <= totalPages; i++) {
      const pageBtn = document.createElement('span');
      pageBtn.className = 'page-number';
      pageBtn.textContent = i;
      if (i === currentPage) pageBtn.classList.add('active');
      else pageBtn.classList.remove('active');

      pageBtn.addEventListener('click', () => {
        currentPage = i;
        renderPosts();
        renderPagination();
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });

      pageNumbersContainer.appendChild(pageBtn);
    }
  };

  if (prevPageBtn) {
    prevPageBtn.addEventListener('click', () => {
      if (currentPage > 1) {
        currentPage--;
        renderPosts();
        renderPagination();
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    });
  }

  if (nextPageBtn) {
    nextPageBtn.addEventListener('click', () => {
      const totalPages = Math.max(1, Math.ceil(filteredCards.length / postsPerPage));
      if (currentPage < totalPages) {
        currentPage++;
        renderPosts();
        renderPagination();
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    });
  }

  // === INICIALIZACIÓN ===
  // aseguramos el estado inicial
  filteredCards = Array.from(cards);
  renderPosts();
  renderPagination();
  updateCarouselArrows();

  // Actualizar estado al redimensionar
  window.addEventListener('resize', updateCarouselArrows);
});
