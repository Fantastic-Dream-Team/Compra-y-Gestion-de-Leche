/**
 * Blog.js - Filtros, búsqueda, paginación y carrusel
 * Versión optimizada y limpia
 */

document.addEventListener('DOMContentLoaded', () => {
  // === SELECTORES ===
  const elements = {
    categories: document.getElementById('categories'),
    categoryBtns: document.querySelectorAll('.category-btn'),
    cards: document.querySelectorAll('.card'),
    searchInput: document.getElementById('search-input'),
    prevArrow: document.querySelector('.arrow.left'),
    nextArrow: document.querySelector('.arrow.right'),
    prevPage: document.getElementById('prev-page'),
    nextPage: document.getElementById('next-page'),
    pageNumbers: document.getElementById('page-numbers')
  };

  // === ESTADO ===
  let currentPage = 1;
  const postsPerPage = 9;
  let filteredCards = [...elements.cards];

  // === CARRUSEL DE CATEGORÍAS ===
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

    filteredCards = [...elements.cards].filter(card => {
      const type = card.dataset.type;
      const title = card.querySelector('h3')?.textContent.toLowerCase() || '';
      const desc = card.querySelector('p')?.textContent.toLowerCase() || '';

      const matchesFilter = activeFilter === 'all' || type === activeFilter;
      const matchesSearch = !term || title.includes(term) || desc.includes(term);

      return matchesFilter && matchesSearch;
    });

    currentPage = 1;
    render();
  };

  elements.categoryBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      elements.categoryBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      applyFilters();
    });
  });

  elements.searchInput?.addEventListener('input', applyFilters);

  // === RENDER ===
  const renderPosts = () => {
    elements.cards.forEach(card => card.style.display = 'none');
    const start = (currentPage - 1) * postsPerPage;
    const end = start + postsPerPage;
    filteredCards.slice(start, end).forEach(card => card.style.display = 'block');
  };

  const renderPagination = () => {
    if (!elements.pageNumbers) return;
    const totalPages = Math.max(1, Math.ceil(filteredCards.length / postsPerPage));
    elements.pageNumbers.innerHTML = '';

    elements.prevPage.disabled = currentPage === 1;
    elements.nextPage.disabled = currentPage === totalPages;

    for (let i = 1; i <= totalPages; i++) {
      const btn = document.createElement('span');
      btn.className = 'page-number';
      btn.textContent = i;
      if (i === currentPage) btn.classList.add('active');
      btn.addEventListener('click', () => {
        currentPage = i;
        render();
      });
      elements.pageNumbers.appendChild(btn);
    }
  };

  const render = () => {
    renderPosts();
    renderPagination();
  };

  // === PAGINACIÓN ===
  elements.prevPage?.addEventListener('click', () => {
    if (currentPage > 1) {
      currentPage--;
      render();
    }
  });

  elements.nextPage?.addEventListener('click', () => {
    const total = Math.ceil(filteredCards.length / postsPerPage);
    if (currentPage < total) {
      currentPage++;
      render();
    }
  });

  // === INICIALIZACIÓN ===
  render();
  updateArrows();
  window.addEventListener('resize', updateArrows);
});
