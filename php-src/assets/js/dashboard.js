// dashboard.js - Funciones principales para controlar el dashboard del productor

// Variables globales para gráficas
let graficaProduccion = null;
let graficaCalidad = null;
let graficaMensual = null;
let modalAbierto = null;

// ============================================
// FUNCIONES PARA MODALES
// ============================================

// Funciones para abrir y cerrar modales
function openModal(modalId) {
    console.log('Abriendo modal:', modalId);
    const modal = document.getElementById(modalId);
    
    if (modal) {
        // 1. Mostrar el modal
        modal.style.display = 'block';
        modalAbierto = modalId;
        
        // 2. Forzar reflow para asegurar renderizado
        void modal.offsetWidth;
        
        // 3. Agregar animación
        setTimeout(() => {
            const modalContent = modal.querySelector('.modal-content');
            if (modalContent) {
                modalContent.style.opacity = '1';
                modalContent.style.transform = 'scale(1)';
            }
            
            // 4. ESPECIAL PARA MODAL DE ESTADÍSTICAS
            if (modalId === 'estadisticasModal') {
                console.log('Modal de estadísticas abierto - asegurando visibilidad de canvas...');
                
                // Asegurar que los canvas sean visibles
                const canvasIds = ['graficaProduccion', 'graficaCalidad', 'graficaMensual'];
                setTimeout(() => {
                    canvasIds.forEach(id => {
                        const canvas = document.getElementById(id);
                        if (canvas) {
                            // Forzar visibilidad
                            canvas.style.display = 'block';
                            canvas.style.visibility = 'visible';
                            canvas.style.opacity = '1';
                            canvas.width = canvas.offsetWidth || 400;
                            canvas.height = canvas.offsetHeight || 300;
                        }
                    });
                    
                    // Cargar gráficas después de un pequeño delay
                    setTimeout(() => {
                        console.log('Iniciando carga de gráficas...');
                        if (typeof cargarGraficas === 'function') {
                            cargarGraficas();
                        }
                    }, 300);
                }, 100);
            }
        }, 10);
        
        // 5. Bloquear scroll
        document.body.style.overflow = 'hidden';
    } else {
        console.error(`ERROR: Modal con ID "${modalId}" no encontrado`);
    }
}

const originalOpenModal = window.openModal;
window.openModal = function(modalId) {
    originalOpenModal.call(this, modalId);
    
    if (modalId === 'estadisticasModal') {
        console.log('Modal de estadísticas abierto, cargando gráficas...');
        
        // Esperar a que el modal esté completamente renderizado
        setTimeout(() => {
            // Asegurar que los canvas sean visibles
            const canvasIds = ['graficaProduccion', 'graficaCalidad', 'graficaMensual'];
            canvasIds.forEach(id => {
                const canvas = document.getElementById(id);
                if (canvas) {
                    canvas.style.display = 'block';
                    canvas.style.visibility = 'visible';
                    
                    // Forzar reflow
                    void canvas.offsetWidth;
                }
            });
            
            // Cargar gráficas después de asegurar visibilidad
            setTimeout(() => {
                console.log('Iniciando carga de gráficas...');
                cargarGraficas();
            }, 100);
        }, 50);
    }
};

// Función auxiliar para crear canvas si no existen
function crearCanvasSiNoExisten() {
    console.log('Creando canvas faltantes...');
    
    const canvasConfig = [
        { id: 'graficaProduccion', wrapperClass: 'grafica-wrapper' },
        { id: 'graficaCalidad', wrapperClass: 'grafica-wrapper' },
        { id: 'graficaMensual', wrapperClass: 'grafica-wrapper' }
    ];
    
    canvasConfig.forEach(config => {
        let canvas = document.getElementById(config.id);
        if (!canvas) {
            // Buscar el contenedor
            const wrapper = document.querySelector(`.${config.wrapperClass}`);
            if (wrapper) {
                console.log(`Creando canvas ${config.id} en wrapper...`);
                canvas = document.createElement('canvas');
                canvas.id = config.id;
                canvas.width = 400;
                canvas.height = 300;
                wrapper.appendChild(canvas);
            } else {
                console.error(`No se encontró wrapper para ${config.id}`);
            }
        }
    });
    
    // Intentar cargar gráficas de nuevo
    setTimeout(() => {
        if (typeof cargarGraficas === 'function') {
            cargarGraficas();
        }
    }, 100);
}

function closeModal(modalId) {
    console.log('Cerrando modal:', modalId);
    const modal = document.getElementById(modalId);
    if (modal) {
        // Animación de salida
        const modalContent = modal.querySelector('.modal-content');
        if (modalContent) {
            modalContent.style.opacity = '0';
            modalContent.style.transform = 'scale(0.9)';
            setTimeout(() => {
                modal.style.display = 'none';
                modalAbierto = null;
                document.body.style.overflow = 'auto';
            }, 300);
        } else {
            modal.style.display = 'none';
            modalAbierto = null;
            document.body.style.overflow = 'auto';
        }
    }
}

// Cerrar modal al hacer clic fuera del contenido
function setupModalClicks() {
    window.addEventListener('click', function(event) {
        if (modalAbierto) {
            const modal = document.getElementById(modalAbierto);
            if (modal && event.target === modal) {
                closeModal(modalAbierto);
            }
        }
    });
}

// Cerrar modal con la tecla ESC
function setupModalKeyboard() {
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && modalAbierto) {
            closeModal(modalAbierto);
        }
    });
}

// ============================================
// FUNCIONES PARA NOTIFICACIONES
// ============================================

// Actualizar contador de notificaciones
function actualizarContadorNotificaciones() {
    const nuevas = document.querySelectorAll('.notificacion-item.no-leida').length;
    const total = document.querySelectorAll('.notificacion-item').length;
    
    // Actualizar badge en el header
    const badgeNew = document.querySelector('.badge.new');
    if (badgeNew) {
        badgeNew.innerHTML = `<i class="fas fa-envelope"></i> ${nuevas} nuevas`;
    }
}

// Marcar notificación como leída
function marcarComoLeida(idNotificacion, buttonElement) {
    // Actualizar interfaz primero
    const notificacionItem = buttonElement.closest('.notificacion-item');
    notificacionItem.classList.remove('no-leida');
    notificacionItem.classList.add('leida');
    
    var icono = notificacionItem.querySelector('.notificacion-icon i');
    if (icono) {
        icono.classList.remove('fa-envelope');
        icono.classList.add('fa-envelope-open');
        icono.style.color = '#95a5a6';
    }
    
    // Cambiar botón
    buttonElement.outerHTML = `
        <button class="btn-marcar-no-leida" onclick="marcarComoNoLeida(${idNotificacion}, this)">
            <i class="fas fa-envelope"></i> Marcar como no leída
        </button>`;
    
    // Actualizar contador
    actualizarContadorNotificaciones();
    
    // Enviar petición al servidor
    enviarPeticionAJAX('/Compra-y-Gestion-de-Leche/php-src/api/marcar-notificacion.php', {
        id: idNotificacion,
        accion: 'marcar_leida'
    });
}

// Marcar notificación como NO leída
function marcarComoNoLeida(idNotificacion, buttonElement) {
    // Actualizar interfaz primero
    const notificacionItem = buttonElement.closest('.notificacion-item');
    notificacionItem.classList.remove('leida');
    notificacionItem.classList.add('no-leida');
    
    var icono = notificacionItem.querySelector('.notificacion-icon i');
    if (icono) {
        icono.classList.remove('fa-envelope-open');
        icono.classList.add('fa-envelope');
        icono.style.color = '#2ecc71';
    }
    
    // Cambiar botón
    buttonElement.outerHTML = `
        <button class="btn-marcar-leida" onclick="marcarComoLeida(${idNotificacion}, this)">
            <i class="fas fa-check"></i> Marcar como leída
        </button>`;
    
    // Actualizar contador
    actualizarContadorNotificaciones();
    
    // Enviar petición al servidor
    enviarPeticionAJAX('/Compra-y-Gestion-de-Leche/php-src/api/marcar-notificacion.php', {
        id: idNotificacion,
        accion: 'marcar_no_leida'
    });
}

// Marcar TODAS las notificaciones como leídas
function marcarTodasLeidas() {
    if (!confirm('¿Marcar todas las notificaciones como leídas?')) return;
    
    var notificaciones = document.querySelectorAll('.notificacion-item');
    var idsNotificaciones = [];
    
    notificaciones.forEach(function(item) {
        item.classList.remove('no-leida');
        item.classList.add('leida');
        
        var icono = item.querySelector('.notificacion-icon i');
        if (icono) {
            icono.classList.remove('fa-envelope');
            icono.classList.add('fa-envelope-open');
            icono.style.color = '#95a5a6';
        }
        
        var acciones = item.querySelector('.notificacion-actions');
        if (acciones) {
            const notificacionId = item.getAttribute('data-id');
            if (notificacionId) {
                acciones.innerHTML = `
                    <button class="btn-marcar-no-leida" onclick="marcarComoNoLeida(${notificacionId}, this)">
                        <i class="fas fa-envelope"></i> Marcar como no leída
                    </button>`;
                idsNotificaciones.push(notificacionId);
            }
        }
    });
    
    // Actualizar contador
    actualizarContadorNotificaciones();
    
    // Enviar petición al servidor
    enviarPeticionAJAX('/Compra-y-Gestion-de-Leche/php-src/api/marcar-todas-notificaciones.php', {
        ids: idsNotificaciones,
        accion: 'marcar_todas_leidas'
    });
    
    mostrarMensajeExito('Todas las notificaciones han sido marcadas como leídas');
}

// ============================================
// FUNCIONES PARA GRÁFICAS
// ============================================

// Función para cargar datos de gráficas - VERSIÓN CORREGIDA
function cargarGraficas() {
    console.log('=== INICIANDO CARGA DE GRÁFICAS ===');
    
    // 1. Verificar que Chart.js esté cargado
    if (typeof Chart === 'undefined') {
        console.error('ERROR: Chart.js no está cargado');
        mostrarMensajeError('Chart.js no está disponible. Recarga la página.');
        return;
    }
    
    console.log('✓ Chart.js cargado correctamente');
    
    // 2. Verificar existencia de todos los canvas
    const canvasIds = ['graficaProduccion', 'graficaCalidad', 'graficaMensual'];
    const canvasExistencias = {};
    let todosExisten = true;
    
    // Asegurar que los canvas sean visibles antes de cargar
    canvasIds.forEach(id => {
        const canvas = document.getElementById(id);
        if (canvas) {
            // Asegurar visibilidad del canvas
            canvas.style.display = 'block';
            canvas.style.visibility = 'visible';
            canvas.style.opacity = '1';
            
            // Asegurar que tenga dimensiones
            if (canvas.width === 0 || canvas.height === 0) {
                canvas.width = canvas.offsetWidth || 400;
                canvas.height = canvas.offsetHeight || 300;
            }
        }
        
        canvasExistencias[id] = {
            existe: !!canvas,
            elemento: canvas
        };
        if (!canvas) {
            console.error(`✗ Canvas "${id}" NO encontrado en el DOM`);
            todosExisten = false;
        } else {
            console.log(`✓ Canvas "${id}" encontrado`, {
                dimensiones: `${canvas.width}x${canvas.height}`,
                visible: window.getComputedStyle(canvas).display !== 'none'
            });
        }
    });
    
    if (!todosExisten) {
        console.error('ERROR: Faltan canvas en el DOM');
        mostrarMensajeError('Error al cargar gráficas: elementos faltantes');
        return;
    }
    
    console.log('✓ Todos los canvas encontrados');
    
    // 3. Mostrar loading en todas las gráficas
    canvasIds.forEach(id => {
        mostrarLoadingGrafica(id, true);
    });
    
    // 4. Cargar datos de producción semanal
    fetch('/Compra-y-Gestion-de-Leche/php-src/api/estadisticas_data.php?tipo=semanal')
        .then(response => {
            console.log('Respuesta producción:', response.status, response.statusText);
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos producción recibidos:', data);
            if (data.error) {
                console.error('Error en datos:', data.error);
                mostrarErrorGrafica('graficaProduccion', 'Error en datos: ' + data.error);
                return;
            }
            crearGraficaProduccion(data);
            actualizarStatsProduccion(data);
        })
        .catch(error => {
            console.error('Error en fetch producción:', error);
            mostrarErrorGrafica('graficaProduccion', 'Error de conexión: ' + error.message);
        });
    
    // Cargar datos de distribución de calidad
    fetch('/Compra-y-Gestion-de-Leche/php-src/api/estadisticas_data.php?tipo=calidad')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error HTTP: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos calidad:', data);
            if (data.error) {
                mostrarErrorGrafica('graficaCalidad', 'Error al cargar datos');
                return;
            }
            crearGraficaCalidad(data);
            actualizarStatsCalidad(data);
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarErrorGrafica('graficaCalidad', 'Error de conexión');
        });
    
    // Cargar datos de tendencia mensual
    fetch('/Compra-y-Gestion-de-Leche/php-src/api/estadisticas_data.php?tipo=mensual')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error HTTP: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos mensual:', data);
            if (data.error) {
                mostrarErrorGrafica('graficaMensual', 'Error al cargar datos');
                return;
            }
            crearGraficaMensual(data);
            actualizarStatsMensual(data);
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarErrorGrafica('graficaMensual', 'Error de conexión');
        });

         // Timeout de seguridad para remover loadings si algo falla
    setTimeout(() => {
        removerTodosLosLoadings();
    }, 10000);
}

// Crear gráfica de producción semanal - VERSIÓN CORREGIDA
function crearGraficaProduccion(data) {
    console.log('=== CREANDO GRÁFICA DE PRODUCCIÓN ===');
    
    const canvas = document.getElementById('graficaProduccion');
    if (!canvas) {
        console.error('Canvas graficaProduccion no encontrado');
        mostrarErrorGrafica('graficaProduccion', 'Elemento gráfica no encontrado');
        return;
    }
    
    // Ocultar loading primero
    mostrarLoadingGrafica('graficaProduccion', false);
    
    const ctx = canvas.getContext('2d');
    if (!ctx) {
        console.error('No se pudo obtener contexto 2D');
        mostrarErrorGrafica('graficaProduccion', 'Error de contexto gráfico');
        return;
    }
    
    // Destruir gráfica anterior si existe
    if (graficaProduccion) {
        graficaProduccion.destroy();
    }
    
    console.log('Creando gráfica de producción con datos:', data);
    
    try {
        // Forzar redibujado del canvas
        canvas.style.display = 'none';
        void canvas.offsetWidth; // Trigger reflow
        canvas.style.display = 'block';
        
        graficaProduccion = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw.toFixed(1)} L`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Litros'
                        }
                    }
                }
            }
        });
        
        console.log('Gráfica de producción creada y visible');
        
    } catch (error) {
        console.error('Error al crear gráfica de producción:', error);
        mostrarErrorGrafica('graficaProduccion', 'Error al crear gráfica: ' + error.message);
    }
}

// Hacer lo mismo para crearGraficaCalidad() y crearGraficaMensual():
function crearGraficaCalidad(data) {
    const canvas = document.getElementById('graficaCalidad');
    if (!canvas) {
        console.error('Canvas graficaCalidad no encontrado');
        mostrarErrorGrafica('graficaCalidad', 'Elemento gráfica no encontrado');
        return;
    }
    
    // Ocultar loading primero
    mostrarLoadingGrafica('graficaCalidad', false);
    
    const ctx = canvas.getContext('2d');
    
    if (graficaCalidad) {
        graficaCalidad.destroy();
    }
    
    try {
        // Forzar redibujado del canvas
        canvas.style.display = 'none';
        void canvas.offsetWidth;
        canvas.style.display = 'block';
        
        graficaCalidad = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 15,
                            padding: 15
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const porcentaje = Math.round((context.raw / total) * 100);
                                return `${context.label}: ${context.raw} entregas (${porcentaje}%)`;
                            }
                        }
                    }
                }
            }
        });
        
        console.log('Gráfica de calidad creada y visible');
        
    } catch (error) {
        console.error('Error al crear gráfica de calidad:', error);
        mostrarErrorGrafica('graficaCalidad', 'Error al crear gráfica');
    }
}

function crearGraficaMensual(data) {
    const canvas = document.getElementById('graficaMensual');
    if (!canvas) {
        console.error('Canvas graficaMensual no encontrado');
        mostrarErrorGrafica('graficaMensual', 'Elemento gráfica no encontrado');
        return;
    }
    
    // Ocultar loading primero
    mostrarLoadingGrafica('graficaMensual', false);
    
    const ctx = canvas.getContext('2d');
    
    if (graficaMensual) {
        graficaMensual.destroy();
    }
    
    try {
        // Forzar redibujado del canvas
        canvas.style.display = 'none';
        void canvas.offsetWidth;
        canvas.style.display = 'block';
        
        graficaMensual = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Litros'
                        },
                        ticks: {
                            callback: function(value) {
                                return value + ' L';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        console.log('Gráfica mensual creada y visible');
        
    } catch (error) {
        console.error('Error al crear gráfica mensual:', error);
        mostrarErrorGrafica('graficaMensual', 'Error al crear gráfica');
    }
}

// Función para remover el loading overlay de una gráfica específica
function removerLoadingGrafica(canvasId) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    
    const wrapper = canvas.parentElement;
    if (!wrapper) return;
    
    // Buscar y remover el loading overlay
    const loading = wrapper.querySelector('.grafica-loading');
    if (loading) {
        loading.style.display = 'none';
        // Opcional: remover completamente del DOM después de animación
        setTimeout(() => {
            if (loading.parentElement === wrapper) {
                wrapper.removeChild(loading);
            }
        }, 300);
    }
    
    // Mostrar el canvas
    canvas.style.opacity = '1';
    canvas.style.pointerEvents = 'auto';
    canvas.style.visibility = 'visible';
    
    console.log(`Loading removido para ${canvasId}`);
}

// Actualizar estadísticas de producción
function actualizarStatsProduccion(data) {
    if (!data.datasets || !data.datasets[0].data) return;
    
    const valores = data.datasets[0].data;
    const hoy = valores[valores.length - 1] || 0;
    const total = valores.reduce((a, b) => a + b, 0);
    const promedio = valores.length > 0 ? total / valores.length : 0;
    
    const hoyElem = document.getElementById('produccionHoy');
    const promedioElem = document.getElementById('produccionPromedio');
    const totalElem = document.getElementById('produccionTotal');
    
    if (hoyElem) hoyElem.textContent = `${hoy.toFixed(1)} L`;
    if (promedioElem) promedioElem.textContent = `${promedio.toFixed(1)} L`;
    if (totalElem) totalElem.textContent = `${total.toFixed(0)} L`;
}

// Actualizar estadísticas de calidad
function actualizarStatsCalidad(data) {
    if (!data.datasets || !data.datasets[0].data) return;
    
    const valores = data.datasets[0].data;
    const labels = data.labels;
    const total = valores.reduce((a, b) => a + b, 0);
    
    // Buscar valores por calidad
    let excelente = 0, buena = 0;
    
    labels.forEach((label, index) => {
        if (label && label.includes('Excelente')) excelente = valores[index];
        if (label && label.includes('Buena')) buena = valores[index];
    });
    
    const excelenteElem = document.getElementById('calidadExcelente');
    const buenaElem = document.getElementById('calidadBuena');
    const totalElem = document.getElementById('totalEntregas');
    
    if (excelenteElem) excelenteElem.textContent = excelente;
    if (buenaElem) buenaElem.textContent = buena;
    if (totalElem) totalElem.textContent = total;
}

// Actualizar estadísticas mensuales
function actualizarStatsMensual(data) {
    if (!data.datasets || !data.datasets[0].data) return;
    
    const valores = data.datasets[0].data;
    const mesActual = valores[valores.length - 1] || 0;
    const mesAnterior = valores[valores.length - 2] || 0;
    
    // Calcular variación
    let variacion = 0;
    if (mesAnterior > 0) {
        variacion = ((mesActual - mesAnterior) / mesAnterior) * 100;
    }
    
    // Encontrar mejor mes
    const maxIndex = valores.indexOf(Math.max(...valores));
    const mejorMes = data.labels[maxIndex] || '-';
    
    const mesActualElem = document.getElementById('produccionMesActual');
    const variacionElem = document.getElementById('variacionMensual');
    const mejorMesElem = document.getElementById('mejorMes');
    
    if (mesActualElem) mesActualElem.textContent = `${mesActual.toFixed(0)} L`;
    if (mejorMesElem) mejorMesElem.textContent = mejorMes;
    
    if (variacionElem) {
        // Color de variación
        if (variacion > 0) {
            variacionElem.style.color = '#2ecc71';
            variacionElem.innerHTML = `+${variacion.toFixed(1)}% <i class="fas fa-arrow-up"></i>`;
        } else if (variacion < 0) {
            variacionElem.style.color = '#e74c3c';
            variacionElem.innerHTML = `${variacion.toFixed(1)}% <i class="fas fa-arrow-down"></i>`;
        } else {
            variacionElem.textContent = '0%';
            variacionElem.style.color = '#7f8c8d';
        }
    }
}

// ============================================
// FUNCIONES PARA MANEJAR LOADING/ERROR DE GRÁFICAS
// ============================================
// Función para mostrar/ocultar loading - VERSIÓN CORREGIDA
function mostrarLoadingGrafica(canvasId, mostrar) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) {
        console.error(`Canvas ${canvasId} no encontrado`);
        return;
    }
    
    const wrapper = canvas.parentElement;
    if (!wrapper) {
        console.error(`Wrapper para ${canvasId} no encontrado`);
        return;
    }
    
    // Buscar o crear loading
    let loading = wrapper.querySelector('.loading-grafica');
    let error = wrapper.querySelector('.error-grafica');
    
    if (mostrar) {
        // Mostrar loading, ocultar error y canvas
        if (loading) {
            loading.classList.remove('hidden');
        } else {
            // Crear loading si no existe
            loading = document.createElement('div');
            loading.className = 'loading-grafica';
            loading.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Cargando datos...</span>';
            wrapper.appendChild(loading);
        }
        
        // Ocultar error si existe
        if (error) {
            error.classList.add('hidden');
        }
        
        // Ocultar canvas temporalmente
        canvas.style.opacity = '0';
        canvas.style.pointerEvents = 'none';
    } else {
        // Ocultar loading, mostrar canvas
        if (loading) {
            loading.classList.add('hidden');
        }
        
        // Mostrar canvas con animación
        canvas.style.opacity = '1';
        canvas.style.pointerEvents = 'auto';
        
        // Ocultar error si existe
        if (error) {
            error.classList.add('hidden');
        }
    }
}

// Función para mostrar error - VERSIÓN CORREGIDA
function mostrarErrorGrafica(canvasId, mensaje) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    
    const wrapper = canvas.parentElement;
    if (!wrapper) return;
    
    // Ocultar loading
    mostrarLoadingGrafica(canvasId, false);
    
    // Mostrar error
    let error = wrapper.querySelector('.error-grafica');
    if (!error) {
        error = document.createElement('div');
        error.className = 'error-grafica';
        error.innerHTML = `
            <i class="fas fa-exclamation-triangle"></i>
            <p>${mensaje}</p>
            <button onclick="cargarGraficas()">Reintentar</button>
        `;
        wrapper.appendChild(error);
    } else {
        error.querySelector('p').textContent = mensaje;
        error.classList.remove('hidden');
    }
    
    // Ocultar canvas
    canvas.style.opacity = '0';
}

// Función para remover todos los loadings (seguridad)
function removerTodosLosLoadings() {
    document.querySelectorAll('.loading-grafica').forEach(loading => {
        loading.classList.add('hidden');
    });
    
    // Mostrar todos los canvas
    ['graficaProduccion', 'graficaCalidad', 'graficaMensual'].forEach(id => {
        const canvas = document.getElementById(id);
        if (canvas) {
            canvas.style.opacity = '1';
            canvas.style.pointerEvents = 'auto';
        }
    });
}

// Cambiar período de gráficas
function cambiarPeriodoGrafica(periodo) {
    console.log('Cambiando período a:', periodo);
    cargarGraficas();
}

// ============================================
// FUNCIONES AUXILIARES
// ============================================

// Función auxiliar para enviar peticiones AJAX
function enviarPeticionAJAX(url, datos) {
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(datos)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.json();
    })
    .then(data => {
        console.log('Respuesta del servidor:', data);
        if (data.error) {
            console.error('Error:', data.error);
            mostrarMensajeError('Error: ' + data.error);
        } else if (data.success) {
            mostrarMensajeExito(data.message || 'Operación exitosa');
        }
    })
    .catch(error => {
        console.error('Error en la petición AJAX:', error);
        mostrarMensajeError('Error de conexión con el servidor');
    });
}

// Función para registrar entrega
function registrarEntrega(event) {
    if (event) event.preventDefault();
    
    // Obtener valores del formulario
    const litros = document.getElementById('litros')?.value;
    const calidad = document.getElementById('calidad')?.value;
    const fecha = document.getElementById('fecha')?.value;
    const observaciones = document.getElementById('observaciones')?.value;
    
    // Validar datos
    if (!litros || litros <= 0) {
        mostrarMensajeError('Por favor ingrese una cantidad de litros válida');
        return false;
    }
    
    if (!calidad) {
        mostrarMensajeError('Por favor seleccione la calidad');
        return false;
    }
    
    if (!fecha) {
        mostrarMensajeError('Por favor seleccione la fecha de entrega');
        return false;
    }
    
    // Aquí iría la llamada AJAX para guardar en base de datos
    console.log('Entrega a registrar:', { litros, calidad, fecha, observaciones });
    
    // Mostrar mensaje de éxito
    mostrarMensajeExito('Entrega registrada exitosamente');
    
    // Cerrar modal
    closeModal('registrarEntregaModal');
    
    // Limpiar formulario
    limpiarFormularioEntrega();
    
    return false;
}

// Función para limpiar formulario de entrega
function limpiarFormularioEntrega() {
    var form = document.getElementById('formRegistrarEntrega');
    if (form) {
        form.reset();
        
        // Restablecer fecha actual
        var fechaInput = document.getElementById('fecha');
        if (fechaInput) {
            var now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            fechaInput.value = now.toISOString().slice(0,16);
        }
    }
}

// Función para mostrar un mensaje de éxito
function mostrarMensajeExito(mensaje) {
    mostrarMensajeNotificacion(mensaje, 'success');
}

// Función para mostrar un mensaje de error
function mostrarMensajeError(mensaje) {
    mostrarMensajeNotificacion(mensaje, 'error');
}

// Función genérica para mostrar mensajes
function mostrarMensajeNotificacion(mensaje, tipo = 'info') {
    const colores = {
        'success': '#2ecc71',
        'error': '#e74c3c',
        'info': '#3498db'
    };
    
    const iconos = {
        'success': 'check-circle',
        'error': 'exclamation-circle',
        'info': 'info-circle'
    };
    
    const mensajeDiv = document.createElement('div');
    mensajeDiv.className = 'mensaje-flotante';
    mensajeDiv.innerHTML = `
        <i class="fas fa-${iconos[tipo]}"></i>
        <span>${mensaje}</span>
        <button onclick="this.parentElement.remove()">&times;</button>
    `;
    
    mensajeDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, ${colores[tipo] || '#3498db'}, ${colores[tipo] ? colores[tipo] + 'CC' : '#2980b9'});
        color: white;
        padding: 15px 20px;
        border-radius: 5px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: slideIn 0.3s ease-out;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-width: 300px;
        max-width: 400px;
    `;
    
    // Remover mensajes anteriores del mismo tipo
    document.querySelectorAll('.mensaje-flotante').forEach(msg => msg.remove());
    
    document.body.appendChild(mensajeDiv);
    
    // Remover automáticamente después de 5 segundos
    setTimeout(() => {
        if (mensajeDiv.parentElement) {
            mensajeDiv.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => {
                if (mensajeDiv.parentElement) {
                    mensajeDiv.parentElement.removeChild(mensajeDiv);
                }
            }, 300);
        }
    }, 5000);
}

// ============================================
// INICIALIZACIÓN
// ============================================

// Función de inicialización
function inicializarDashboard() {
    console.log('=== INICIALIZANDO DASHBOARD ===');
    
    // 1. Configurar modales
    setupModalClicks();
    setupModalKeyboard();
    
    // 2. Configurar botones de cerrar modales
    document.querySelectorAll('.modal .close').forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            if (modal && modal.id) {
                closeModal(modal.id);
            }
        });
    });
    
    // 3. Configurar formulario de entrega
    const formRegistrarEntrega = document.getElementById('formRegistrarEntrega');
    if (formRegistrarEntrega) {
        formRegistrarEntrega.addEventListener('submit', registrarEntrega);
    }
    
    // 4. Configurar fecha por defecto en formulario de entrega
    var fechaInput = document.getElementById('fecha');
    if (fechaInput && !fechaInput.value) {
        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        fechaInput.value = now.toISOString().slice(0,16);
    }
    
    // 5. Inicializar tooltips para botones de acciones rápidas
    var actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(function(button) {
        button.setAttribute('title', 'Haz clic para abrir');
        
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
            this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
    
    // 6. Agregar animaciones CSS si no existen
    if (!document.querySelector('#animaciones-css')) {
        var estiloAnimaciones = document.createElement('style');
        estiloAnimaciones.id = 'animaciones-css';
        estiloAnimaciones.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
            
            .mensaje-flotante button {
                background: none;
                border: none;
                color: white;
                font-size: 20px;
                cursor: pointer;
                padding: 0;
                margin-left: 10px;
                opacity: 0.8;
                transition: opacity 0.2s;
            }
            
            .mensaje-flotante button:hover {
                opacity: 1;
            }
            
            .modal-content {
                animation: modalFadeIn 0.3s;
            }
            
            @keyframes modalFadeIn {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .loading-grafica {
                text-align: center;
                padding: 40px;
                color: #7f8c8d;
                font-size: 16px;
            }
            
            .error-grafica {
                text-align: center;
                padding: 30px;
                color: #e74c3c;
                background: #fdf2f2;
                border-radius: 8px;
                border: 1px solid #f8d7da;
            }
        `;
        document.head.appendChild(estiloAnimaciones);
    }
    
    // 7. Actualizar contador de notificaciones
    setTimeout(() => {
        actualizarContadorNotificaciones();
    }, 1000);
    
    console.log('=== DASHBOARD INICIALIZADO ===');
}

// Inicializar cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', inicializarDashboard);
} else {
    inicializarDashboard();
}

// Exportar funciones al ámbito global
window.openModal = openModal;
window.closeModal = closeModal;
window.marcarComoLeida = marcarComoLeida;
window.marcarComoNoLeida = marcarComoNoLeida;
window.marcarTodasLeidas = marcarTodasLeidas;
window.registrarEntrega = registrarEntrega;
window.limpiarFormularioEntrega = limpiarFormularioEntrega;
window.cargarGraficas = cargarGraficas;
window.cambiarPeriodoGrafica = cambiarPeriodoGrafica;