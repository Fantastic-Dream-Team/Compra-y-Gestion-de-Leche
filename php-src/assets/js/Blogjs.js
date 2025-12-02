document.addEventListener('DOMContentLoaded', () => {
  // ================= SELECTORES =================
  const categoriesContainer = document.getElementById('categories');
  const categoryBtns       = document.querySelectorAll('.category-btn');
  const cards              = document.querySelectorAll('.card');
  const searchInput        = document.getElementById('search-input');
  const prevArrow          = document.querySelector('.arrow.left');
  const nextArrow          = document.querySelector('.arrow.right');
  const prevPage           = document.getElementById('prev-page');
  const nextPage           = document.getElementById('next-page');
  const pageNumbersDiv     = document.getElementById('page-numbers');

  // ================= ESTADO =================
  let currentPage = 1;
  const postsPerPage = 9;
  let filteredCards = Array.from(cards);

  // ================= CARRUSEL DE CATEGORÍAS =================
  const updateArrows = () => {
    if (!categoriesContainer) return;
    const atStart = categoriesContainer.scrollLeft <= 5;
    const atEnd   = categoriesContainer.scrollLeft >= (categoriesContainer.scrollWidth - categoriesContainer.clientWidth - 5);
    prevArrow.disabled = atStart;
    nextArrow.disabled = atEnd;
  };

  prevArrow?.addEventListener('click', () => {
    categoriesContainer.scrollBy({ left: -150, behavior: 'smooth' });
  });
  nextArrow?.addEventListener('click', () => {
    categoriesContainer.scrollBy({ left: 150, behavior: 'smooth' });
  });
  categoriesContainer?.addEventListener('scroll', updateArrows);
  updateArrows();

  // ================= FILTROS Y BÚSQUEDA =================
  const applyFilters = () => {
    const activeFilter = document.querySelector('.category-btn.active')?.dataset.filter || 'all';
    const term = searchInput.value.toLowerCase().trim();

    filteredCards = Array.from(cards).filter(card => {
      const type = card.dataset.type;
      const title = card.querySelector('h3')?.textContent.toLowerCase() || '';
      const text  = card.querySelector('p')?.textContent.toLowerCase() || '';

      const matchFilter = activeFilter === 'all' || type === activeFilter;
      const matchSearch = !term || title.includes(term) || text.includes(term);

      card.style.display = matchFilter && matchSearch ? 'block' : 'none';
      return matchFilter && matchSearch;
    });

    currentPage = 1;
    renderPagination();
    showPage();
  };

  categoryBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      categoryBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      applyFilters();
    });
  });

  searchInput?.addEventListener('input', applyFilters);

  // ================= PAGINACIÓN =================
  const showPage = () => {
    const start = (currentPage - 1) * postsPerPage;
    const end   = start + postsPerPage;

    filteredCards.forEach((card, i) => {
      card.style.display = (i >= start && i < end) ? 'block' : 'none';
    });
  };

  const renderPagination = () => {
    if (!pageNumbersDiv) return;
    pageNumbersDiv.innerHTML = '';

    const totalPages = Math.max(1, Math.ceil(filteredCards.length / postsPerPage));

    prevPage.disabled = currentPage === 1;
    nextPage.disabled = currentPage === totalPages;

    for (let i = 1; i <= totalPages; i++) {
      const btn = document.createElement('span');
      btn.className = 'page-number';
      btn.textContent = i;
      if (i === currentPage) btn.classList.add('active');
      btn.addEventListener('click', () => {
        currentPage = i;
        showPage();
        renderPagination();
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
      pageNumbersDiv.appendChild(btn);
    }
  };

  prevPage?.addEventListener('click', () => {
    if (currentPage > 1) { currentPage--; showPage(); renderPagination(); }
  });
  nextPage?.addEventListener('click', () => {
    if (currentPage < Math.ceil(filteredCards.length / postsPerPage)) {
      currentPage++; showPage(); renderPagination();
    }
  });

  // ================= INICIALIZACIÓN =================
  renderPagination();
  showPage();
  window.addEventListener('resize', updateArrows);
});