/**
 * FUNCIONES GENERALES - Lácteos Don Joaquín
 * Archivo compartido por todas las páginas
 */

// ====== FUNCIONES DE NAVEGACIÓN ======

/**
 * Marca el enlace activo en la navegación
 */
function marcarEnlaceActivo() {
    const currentPage = window.location.pathname.split('/').pop() || 'index.php';
    const navLinks = document.querySelectorAll('nav ul li a');
    
    navLinks.forEach(link => {
        const linkPage = link.getAttribute('href').split('/').pop();
        if (currentPage === linkPage || 
            (currentPage === '' && linkPage === 'index.php') ||
            link.href === window.location.href) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}

/**
 * Smooth scroll para enlaces internos
 */
function inicializarScrollSuave() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// ====== FUNCIONES DE MENSAJES Y NOTIFICACIONES ======

/**
 * Muestra un mensaje toast (notificación flotante)
 * @param {string} mensaje - Texto a mostrar
 * @param {string} tipo - 'exito', 'error', 'info', 'advertencia'
 */
function mostrarToast(mensaje, tipo = 'info') {
    // Crear contenedor si no existe
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        `;
        document.body.appendChild(toastContainer);
    }
    
    // Crear toast
    const toast = document.createElement('div');
    toast.className = `toast toast-${tipo}`;
    toast.innerHTML = `
        <span>${mensaje}</span>
        <button class="toast-cerrar">&times;</button>
    `;
    
    // Estilos del toast
    const tipoColores = {
        'exito': '#4CAF50',
        'error': '#F44336',
        'info': '#2196F3',
        'advertencia': '#FF9800'
    };
    
    toast.style.cssText = `
        background: ${tipoColores[tipo] || '#2196F3'};
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        display: flex;
        justify-content: space-between;
        align-items: center;
        animation: slideIn 0.3s ease;
        min-width: 300px;
        max-width: 400px;
    `;
    
    // Botón cerrar
    const btnCerrar = toast.querySelector('.toast-cerrar');
    btnCerrar.style.cssText = `
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        line-height: 1;
        padding: 0;
        margin-left: 15px;
    `;
    
    btnCerrar.addEventListener('click', () => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    });
    
    // Agregar al contenedor
    toastContainer.appendChild(toast);
    
    // Auto-remover después de 5 segundos
    setTimeout(() => {
        if (toast.parentElement) {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }
    }, 5000);
}

// ====== FUNCIONES DE FORMULARIOS ======

/**
 * Valida un formulario básico
 * @param {HTMLFormElement} form - Formulario a validar
 * @returns {boolean} - true si es válido
 */
function validarFormulario(form) {
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let valido = true;
    
    inputs.forEach(input => {
        // Resetear estilos
        input.style.borderColor = '';
        
        if (!input.value.trim()) {
            input.style.borderColor = '#F44336';
            mostrarToast(`Por favor, complete el campo: ${input.name || input.placeholder || 'Campo obligatorio'}`, 'error');
            valido = false;
        }
        
        // Validar email si tiene tipo email
        if (input.type === 'email' && input.value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(input.value)) {
                input.style.borderColor = '#F44336';
                mostrarToast('Por favor, ingrese un email válido', 'error');
                valido = false;
            }
        }
    });
    
    return valido;
}

/**
 * Agrega máscara de teléfono a inputs
 */
function inicializarMascaras() {
    const telefonoInputs = document.querySelectorAll('input[type="tel"]');
    
    telefonoInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 0) {
                value = '(' + value.substring(0, 3) + ') ' + value.substring(3, 6) + '-' + value.substring(6, 10);
            }
            this.value = value;
        });
    });
}

// ====== FUNCIONES DE RESPONSIVE ======

/**
 * Detecta si el dispositivo es móvil
 * @returns {boolean}
 */
function esMovil() {
    return window.innerWidth <= 768;
}

/**
 * Toggle para menús responsive
 */
function inicializarMenuResponsive() {
    const menuToggle = document.getElementById('menu-toggle');
    const navMenu = document.querySelector('nav ul');
    
    if (!menuToggle || !navMenu) return;
    
    menuToggle.addEventListener('click', () => {
        navMenu.classList.toggle('show');
        menuToggle.classList.toggle('active');
    });
    
    // Cerrar menú al hacer clic fuera
    document.addEventListener('click', (e) => {
        if (!navMenu.contains(e.target) && !menuToggle.contains(e.target)) {
            navMenu.classList.remove('show');
            menuToggle.classList.remove('active');
        }
    });
}

// ====== FUNCIONES DE CARGA Y ANIMACIONES ======

/**
 * Detecta cuando un elemento es visible en pantalla
 * @param {Element} element - Elemento a observar
 * @param {Function} callback - Función a ejecutar cuando es visible
 */
function observarElemento(element, callback) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                callback(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    observer.observe(element);
}

/**
 * Inicializa animaciones de aparición
 */
function inicializarAnimaciones() {
    const elementosAnimados = document.querySelectorAll('.fade-in, .slide-in, .zoom-in');
    
    elementosAnimados.forEach(elemento => {
        observarElemento(elemento, (el) => {
            el.classList.add('animado');
        });
    });
}

// ====== FUNCIONES DE COOKIES Y ALMACENAMIENTO ======

/**
 * Guarda datos en localStorage
 * @param {string} clave - Clave para guardar
 * @param {any} valor - Valor a guardar
 */
function guardarEnStorage(clave, valor) {
    try {
        localStorage.setItem(clave, JSON.stringify(valor));
    } catch (e) {
        console.error('Error al guardar en localStorage:', e);
    }
}

/**
 * Obtiene datos de localStorage
 * @param {string} clave - Clave a obtener
 * @returns {any} - Valor almacenado
 */
function obtenerDeStorage(clave) {
    try {
        const valor = localStorage.getItem(clave);
        return valor ? JSON.parse(valor) : null;
    } catch (e) {
        console.error('Error al obtener de localStorage:', e);
        return null;
    }
}

// ====== INICIALIZACIÓN ======

/**
 * Inicializa todas las funciones generales
 */
document.addEventListener('DOMContentLoaded', function() {
    // Navegación
    marcarEnlaceActivo();
    inicializarScrollSuave();
    
    // Formularios
    inicializarMascaras();
    
    // Responsive
    inicializarMenuResponsive();
    
    // Animaciones
    inicializarAnimaciones();
    
    // Estilos para toast (CSS dinámico)
    if (!document.querySelector('#toast-styles')) {
        const style = document.createElement('style');
        style.id = 'toast-styles';
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    }
    
    console.log('Funciones generales inicializadas correctamente');
});

// ====== EXPORTAR FUNCIONES (si se usa módulos) ======
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        mostrarToast,
        validarFormulario,
        esMovil,
        guardarEnStorage,
        obtenerDeStorage
    };
}
