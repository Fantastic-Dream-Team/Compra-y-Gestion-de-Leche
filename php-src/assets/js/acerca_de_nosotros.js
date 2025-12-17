/**
 * ACERCA DE NOSOTROS - Lácteos Don Joaquín
 * Funciones específicas para la página "Acerca de Nosotros"
 */

// ====== VARIABLES GLOBALES ======
let seccionesVisibles = new Set();
let equipoHoverTimer = null;
let navegacionInternaVisible = false;
let observadorHistoria = null;

// ====== INICIALIZACIÓN ======
document.addEventListener('DOMContentLoaded', function() {
    console.log('Acerca de Nosotros - JS inicializado');
    
    // Inicializar funcionalidades
    inicializarObservadorSecciones();
    inicializarEfectosHover();
    inicializarNavegacionInterna();
    inicializarAnimacionesValores();
    inicializarTestimoniosAutomaticos();
    
    // Inicializar observador específico para la sección Historia
    inicializarObservadorHistoria();
    
    // Ajustar alturas de tarjetas
    setTimeout(ajustarAlturasTarjetas, 500);
    
    // Cargar datos del equipo (simulación)
    cargarInformacionEquipo();
});

// ====== OBSERVADOR DE SECCIONES ======

/**
 * Inicializa el observador para detectar secciones visibles
 */
function inicializarObservadorSecciones() {
    const secciones = document.querySelectorAll('.acerca-section, .testimonials-section');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.id || entry.target.className;
                seccionesVisibles.add(id);
                entry.target.classList.add('visible');
                
                // Actualizar navegación interna
                actualizarNavegacionActiva(entry.target.id);
                
                // Mostrar en consola para debug
                console.log(`Sección visible: ${id}`);
            }
        });
    }, { threshold: 0.2 });
    
    secciones.forEach(seccion => {
        observer.observe(seccion);
    });
}

/**
 * Inicializa observador específico para la sección Historia
 */
function inicializarObservadorHistoria() {
    const seccionHistoria = document.getElementById('historia');
    if (!seccionHistoria) return;
    
    observadorHistoria = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Mostrar navegación interna cuando se entra a Historia
                mostrarNavegacionInterna();
                console.log('🔍 Sección Historia visible - Mostrando navegación interna');
            } else {
                // Solo ocultar si no estamos en ninguna sección importante
                const seccionesImportantes = ['historia', 'mision', 'testimonios'];
                const seccionActual = obtenerSeccionVisible();
                
                if (!seccionesImportantes.includes(seccionActual)) {
                    ocultarNavegacionInterna();
                }
            }
        });
    }, { threshold: 0.3 });
    
    observadorHistoria.observe(seccionHistoria);
}

/**
 * Obtiene la sección actualmente visible
 */
function obtenerSeccionVisible() {
    const secciones = ['historia', 'mision', 'testimonios'];
    
    for (const seccionId of secciones) {
        const elemento = document.getElementById(seccionId);
        if (elemento) {
            const rect = elemento.getBoundingClientRect();
            if (rect.top < window.innerHeight * 0.7 && rect.bottom > window.innerHeight * 0.3) {
                return seccionId;
            }
        }
    }
    
    return null;
}

// ====== CONTROL DE NAVEGACIÓN INTERNA ======

/**
 * Muestra la navegación interna
 */
function mostrarNavegacionInterna() {
    const navegacion = document.getElementById('navegacion-interna');
    if (navegacion && !navegacionInternaVisible) {
        navegacion.classList.add('visible');
        navegacionInternaVisible = true;
        console.log('📍 Navegación interna visible');
    }
}

/**
 * Oculta la navegación interna
 */
function ocultarNavegacionInterna() {
    const navegacion = document.getElementById('navegacion-interna');
    if (navegacion && navegacionInternaVisible) {
        navegacion.classList.remove('visible');
        navegacionInternaVisible = false;
        console.log('📍 Navegación interna oculta');
    }
}

/**
 * Actualiza el enlace activo en la navegación interna
 */
function actualizarNavegacionActiva(seccionId) {
    const navegacion = document.getElementById('navegacion-interna');
    if (!navegacion) return;
    
    const enlaces = navegacion.querySelectorAll('a');
    enlaces.forEach(enlace => {
        const href = enlace.getAttribute('href');
        if (href === `#${seccionId}`) {
            enlace.classList.add('active');
        } else {
            enlace.classList.remove('active');
        }
    });
}

// ====== NAVEGACIÓN INTERNA ======

/**
 * Inicializa la navegación suave entre secciones
 */
function inicializarNavegacionInterna() {
    // Agregar IDs a secciones que no los tengan
    const secciones = document.querySelectorAll('.acerca-section');
    secciones.forEach((seccion, index) => {
        if (!seccion.id) {
            seccion.id = `seccion-${index + 1}`;
        }
    });
    
    // Crear menú de navegación interna si no existe
    if (!document.getElementById('navegacion-interna')) {
        crearMenuNavegacionInterna();
    }
    
    // Scroll a secciones
    document.querySelectorAll('a[href^="#"]').forEach(enlace => {
        enlace.addEventListener('click', function(e) {
            const destino = this.getAttribute('href');
            if (destino === '#' || !destino.startsWith('#seccion-') && 
                !['#historia', '#mision', '#testimonios'].includes(destino)) return;
            
            e.preventDefault();
            const seccion = document.querySelector(destino);
            if (seccion) {
                window.scrollTo({
                    top: seccion.offsetTop - 100,
                    behavior: 'smooth'
                });
                
                // Asegurar que la navegación sea visible
                mostrarNavegacionInterna();
                
                // Resaltar sección
                seccion.style.boxShadow = '0 0 0 4px rgba(195, 84, 28, 0.3)';
                setTimeout(() => {
                    seccion.style.boxShadow = '';
                }, 1000);
            }
        });
    });
}

/**
 * Crea un menú de navegación interna flotante
 */
function crearMenuNavegacionInterna() {
    const secciones = document.querySelectorAll('.acerca-section');
    if (secciones.length === 0) return;
    
    const nav = document.createElement('nav');
    nav.id = 'navegacion-interna';
    
    // Títulos de secciones principales
    const seccionesPrincipales = [
        { id: 'historia', titulo: '📜 Historia' },
        { id: 'mision', titulo: '🎯 Misión & Visión' },
        { id: 'seccion-3', titulo: '💎 Valores' },
        { id: 'testimonios', titulo: '💬 Testimonios' },
        { id: 'seccion-4', titulo: '👥 Equipo' }
    ];
    
    seccionesPrincipales.forEach((seccion) => {
        const elemento = document.getElementById(seccion.id);
        if (!elemento) return;
        
        const enlace = document.createElement('a');
        enlace.href = `#${seccion.id}`;
        enlace.textContent = seccion.titulo;
        enlace.dataset.section = seccion.id;
        
        enlace.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
                
                // Asegurar que la navegación sea visible
                mostrarNavegacionInterna();
                
                // Actualizar enlace activo
                actualizarNavegacionActiva(seccion.id);
            }
        });
        
        nav.appendChild(enlace);
    });
    
    document.body.appendChild(nav);
    
    console.log('📍 Navegación interna creada (oculta por defecto)');
    
    // Controlar visibilidad en scroll
    let ultimaPosicion = window.pageYOffset;
    let timeoutScroll;
    
    window.addEventListener('scroll', () => {
        clearTimeout(timeoutScroll);
        timeoutScroll = setTimeout(() => {
            const posicionActual = window.pageYOffset;
            const seccionActual = obtenerSeccionVisible();
            
            // Mostrar navegación si estamos en una sección importante y scrolleamos hacia abajo
            if (seccionActual && ['historia', 'mision', 'testimonios'].includes(seccionActual)) {
                if (posicionActual > 300 && posicionActual > ultimaPosicion) {
                    mostrarNavegacionInterna();
                }
            }
            
            // Ocultar si estamos cerca del top o scrolleando hacia arriba
            if (posicionActual < 300 || posicionActual < ultimaPosicion) {
                ocultarNavegacionInterna();
            }
            
            ultimaPosicion = posicionActual;
        }, 100);
    });
}

// ====== EFECTOS HOVER ======
/**
 * Inicializa efectos hover para tarjetas e imágenes
 */
function inicializarEfectosHover() {
    // Efectos para tarjetas de valores
    const tarjetasValores = document.querySelectorAll('.value-card');
    tarjetasValores.forEach(tarjeta => {
        tarjeta.addEventListener('mouseenter', () => {
            tarjeta.style.transform = 'translateY(-10px) scale(1.02)';
            tarjeta.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.15)';
            
            const icono = tarjeta.querySelector('i');
            if (icono) {
                icono.style.transform = 'scale(1.2) rotate(15deg)';
            }
        });
        
        tarjeta.addEventListener('mouseleave', () => {
            tarjeta.style.transform = '';
            tarjeta.style.boxShadow = '';
            
            const icono = tarjeta.querySelector('i');
            if (icono) {
                icono.style.transform = '';
            }
        });
    });
    
    // Efectos para miembros del equipo
    const miembrosEquipo = document.querySelectorAll('.miembro-equipo');
    miembrosEquipo.forEach(miembro => {
        miembro.addEventListener('mouseenter', () => {
            miembro.style.transform = 'translateY(-10px)';
            miembro.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.15)';
            
            const foto = miembro.querySelector('.miembro-foto img');
            if (foto) {
                foto.style.transform = 'scale(1.1)';
            }
        });
        
        miembro.addEventListener('mouseleave', () => {
            miembro.style.transform = '';
            miembro.style.boxShadow = '';
            
            const foto = miembro.querySelector('.miembro-foto img');
            if (foto) {
                foto.style.transform = '';
            }
        });
    });
    
    // Efectos para tarjetas de misión/visión
    const tarjetasMV = document.querySelectorAll('.mission-card, .vision-card');
    tarjetasMV.forEach(tarjeta => {
        tarjeta.addEventListener('mouseenter', () => {
            tarjeta.style.transform = 'translateY(-10px) scale(1.02)';
            tarjeta.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.15)';
            
            const icono = tarjeta.querySelector('.mv-icon');
            if (icono) {
                icono.style.transform = 'scale(1.2) rotate(10deg)';
            }
        });
        
        tarjeta.addEventListener('mouseleave', () => {
            tarjeta.style.transform = '';
            tarjeta.style.boxShadow = '';
            
            const icono = tarjeta.querySelector('.mv-icon');
            if (icono) {
                icono.style.transform = '';
            }
        });
    });
}

// ====== ANIMACIONES DE VALORES ======
/**
 * Inicializa animaciones secuenciales para los valores
 */
function inicializarAnimacionesValores() {
    const valores = document.querySelectorAll('.value-card');
    
    valores.forEach((valor, index) => {
        // Retraso escalonado
        setTimeout(() => {
            valor.style.animation = `fadeInUp 0.8s ease-out ${index * 0.2}s both`;
        }, 500);
        
        // Efecto de aparición al hacer scroll
        observarElemento(valor, (elemento) => {
            elemento.classList.add('animado');
        });
    });
}

// ====== TESTIMONIOS AUTOMÁTICOS ======
/**
 * Inicializa rotación automática de testimonios
 */
function inicializarTestimoniosAutomaticos() {
    const testimonios = document.querySelectorAll('.testimonial-card');
    if (testimonios.length === 0) return;
    
    let indiceActual = 0;
    
    // Función para mostrar testimonio
    function mostrarTestimonio(indice) {
        testimonios.forEach((test, i) => {
            test.style.opacity = i === indice ? '1' : '0.5';
            test.style.transform = i === indice ? 'scale(1.05)' : 'scale(0.95)';
        });
        
        indiceActual = indice;
    }
    
    // Rotación automática cada 5 segundos
    setInterval(() => {
        const siguiente = (indiceActual + 1) % testimonios.length;
        mostrarTestimonio(siguiente);
    }, 5000);
    
    // Inicializar
    mostrarTestimonio(0);
    
    // Controles manuales
    testimonios.forEach((test, indice) => {
        test.addEventListener('click', () => {
            mostrarTestimonio(indice);
        });
    });
}

// ====== AJUSTES DE DISEÑO ======
/**
 * Ajusta las alturas de las tarjetas para que sean uniformes
 */
function ajustarAlturasTarjetas() {
    // Ajustar tarjetas de valores
    const tarjetasValores = document.querySelectorAll('.value-card');
    let maxAltura = 0;
    
    // Encontrar la altura máxima
    tarjetasValores.forEach(tarjeta => {
        tarjeta.style.height = 'auto';
        const altura = tarjeta.offsetHeight;
        if (altura > maxAltura) maxAltura = altura;
    });
    
    // Aplicar altura máxima
    if (maxAltura > 0) {
        tarjetasValores.forEach(tarjeta => {
            tarjeta.style.height = `${maxAltura}px`;
        });
    }
    
    // Ajustar tarjetas de misión/visión
    const tarjetasMV = document.querySelectorAll('.mission-card, .vision-card');
    maxAltura = 0;
    
    tarjetasMV.forEach(tarjeta => {
        tarjeta.style.height = 'auto';
        const altura = tarjeta.offsetHeight;
        if (altura > maxAltura) maxAltura = altura;
    });
    
    if (maxAltura > 0) {
        tarjetasMV.forEach(tarjeta => {
            tarjeta.style.height = `${maxAltura}px`;
        });
    }
}

// ====== CARGAR INFORMACIÓN DEL EQUIPO ======
/**
 * Simula carga de información del equipo
 */
function cargarInformacionEquipo() {
    const miembros = document.querySelectorAll('.miembro-equipo');
    
    miembros.forEach((miembro, index) => {
        // Agregar efecto de carga
        const foto = miembro.querySelector('.miembro-foto img');
        if (foto) {
            foto.addEventListener('load', () => {
                miembro.classList.add('cargado');
            });
            
            // Simular carga lenta
            setTimeout(() => {
                miembro.classList.add('cargado');
            }, 500 + (index * 300));
        }
    });
}

// ====== FUNCIONES AUXILIARES ======
/**
 * Observa cuando un elemento es visible
 */
function observarElemento(elemento, callback) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                callback(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });
    
    observer.observe(elemento);
}

/**
 * Debounce para eventos resize
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ====== EVENT LISTENERS GLOBALES ======
// Reajustar alturas al cambiar tamaño de ventana
window.addEventListener('resize', debounce(ajustarAlturasTarjetas, 250));

// Mostrar información de depuración
window.addEventListener('load', () => {
    console.log(`Página "Acerca de Nosotros" cargada con ${document.querySelectorAll('.acerca-section').length} secciones`);
});