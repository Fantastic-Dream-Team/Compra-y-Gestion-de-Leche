// dashboard.js - Funciones para controlar modales en el dashboard del productor

// Funciones para abrir y cerrar modales
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Cerrar modal al hacer clic fuera del contenido
window.onclick = function(event) {
    var modals = document.getElementsByClassName('modal');
    for (var i = 0; i < modals.length; i++) {
        if (event.target == modals[i]) {
            modals[i].style.display = 'none';
        }
    }
}

// Cerrar modal con la tecla ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        var modals = document.getElementsByClassName('modal');
        for (var i = 0; i < modals.length; i++) {
            if (modals[i].style.display === 'block') {
                modals[i].style.display = 'none';
            }
        }
    }
});

// Función para marcar notificación como leída
function marcarComoLeida(idNotificacion) {
    // Aquí puedes hacer una petición AJAX para actualizar en la base de datos
    var notificacionItem = event.target.closest('.notificacion-item');
    notificacionItem.classList.remove('no-leida');
    notificacionItem.classList.add('leida');
    
    var icono = notificacionItem.querySelector('.notificacion-icon i');
    icono.classList.remove('fa-envelope');
    icono.classList.add('fa-envelope-open');
    
    // Remover botón de marcar como leída
    var acciones = notificacionItem.querySelector('.notificacion-actions');
    if (acciones) {
        acciones.remove();
    }
    
    // Aquí iría la llamada AJAX para actualizar en la base de datos
    // Deshabilitada temporalmente para evitar errores 404
    // enviarPeticionAJAX('/Compra-y-Gestion-de-Leche/php-src/api/marcar-notificacion.php', {
    //     id: idNotificacion,
    //     accion: 'marcar_leida'
    // });
    
    console.log('Notificación ' + idNotificacion + ' marcada como leída');
}

// Función para marcar todas las notificaciones como leídas
function marcarTodasLeidas() {
    var notificaciones = document.querySelectorAll('.notificacion-item');
    var idsNotificaciones = [];
    
    notificaciones.forEach(function(item) {
        item.classList.remove('no-leida');
        item.classList.add('leida');
        
        var icono = item.querySelector('.notificacion-icon i');
        if (icono) {
            icono.classList.remove('fa-envelope');
            icono.classList.add('fa-envelope-open');
        }
        
        var acciones = item.querySelector('.notificacion-actions');
        if (acciones) {
            acciones.remove();
        }
        
        // Obtener ID de la notificación (esto sería dinámico en producción)
        var id = item.getAttribute('data-id') || 0;
        if (id) idsNotificaciones.push(id);
    });
    
    // Aquí iría la llamada AJAX para actualizar todas en la base de datos
    // Deshabilitada temporalmente para evitar errores 404
    // enviarPeticionAJAX('/Compra-y-Gestion-de-Leche/php-src/api/marcar-todas-notificaciones.php', {
    //     ids: idsNotificaciones,
    //     accion: 'marcar_todas_leidas'
    // });
    
    console.log('Todas las notificaciones marcadas como leídas');
    mostrarMensajeExito('Todas las notificaciones han sido marcadas como leídas');
}

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

// Configurar fecha por defecto en el formulario de entrega
document.addEventListener('DOMContentLoaded', function() {
    // Configurar fecha actual en el campo de fecha
    var fechaInput = document.getElementById('fecha');
    if (fechaInput && !fechaInput.value) {
        var now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        fechaInput.value = now.toISOString().slice(0,16);
    }
    
    // NOTA: La validación del formulario de entrega ya se maneja
    // en la función registrarEntrega() del archivo dashboard.php
    
    // Inicializar tooltips para botones de acciones rápidas
    var actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(function(button) {
        button.setAttribute('title', 'Haz clic para abrir');
        
        // Agregar efecto de hover
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
            this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
    
    // Agregar event listener para cerrar modales con botón de cerrar
    var closeButtons = document.querySelectorAll('.modal .close');
    closeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var modal = this.closest('.modal');
            if (modal) {
                modal.style.display = 'none';
            }
        });
    });
    
    // Agregar animación de entrada a los modales
    var modals = document.querySelectorAll('.modal-content');
    modals.forEach(function(modal) {
        modal.style.opacity = '0';
        modal.style.transform = 'scale(0.9)';
        modal.style.transition = 'opacity 0.3s, transform 0.3s';
    });
    
    // Sobreescribir openModal para agregar animación
    var originalOpenModal = window.openModal;
    window.openModal = function(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
            setTimeout(function() {
                var modalContent = modal.querySelector('.modal-content');
                if (modalContent) {
                    modalContent.style.opacity = '1';
                    modalContent.style.transform = 'scale(1)';
                }
            }, 10);
        }
    };
    
    // Sobreescribir closeModal para agregar animación
    var originalCloseModal = window.closeModal;
    window.closeModal = function(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            var modalContent = modal.querySelector('.modal-content');
            if (modalContent) {
                modalContent.style.opacity = '0';
                modalContent.style.transform = 'scale(0.9)';
                setTimeout(function() {
                    modal.style.display = 'none';
                }, 300);
            } else {
                modal.style.display = 'none';
            }
        }
    };
});

// Función para mostrar un mensaje de éxito
function mostrarMensajeExito(mensaje) {
    var mensajeDiv = document.createElement('div');
    mensajeDiv.className = 'mensaje-exito';
    mensajeDiv.innerHTML = `
        <i class="fas fa-check-circle"></i>
        <span>${mensaje}</span>
        <button onclick="this.parentElement.remove()">&times;</button>
    `;
    mensajeDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #2ecc71, #27ae60);
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
    `;
    
    document.body.appendChild(mensajeDiv);
    
    // Remover automáticamente después de 5 segundos
    setTimeout(function() {
        if (mensajeDiv.parentElement) {
            mensajeDiv.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(function() {
                if (mensajeDiv.parentElement) {
                    mensajeDiv.parentElement.removeChild(mensajeDiv);
                }
            }, 300);
        }
    }, 5000);
}

// Función para mostrar un mensaje de error
function mostrarMensajeError(mensaje) {
    var mensajeDiv = document.createElement('div');
    mensajeDiv.className = 'mensaje-error';
    mensajeDiv.innerHTML = `
        <i class="fas fa-exclamation-circle"></i>
        <span>${mensaje}</span>
        <button onclick="this.parentElement.remove()">&times;</button>
    `;
    mensajeDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #e74c3c, #c0392b);
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
    `;
    
    document.body.appendChild(mensajeDiv);
    
    // Remover automáticamente después de 5 segundos
    setTimeout(function() {
        if (mensajeDiv.parentElement) {
            mensajeDiv.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(function() {
                if (mensajeDiv.parentElement) {
                    mensajeDiv.parentElement.removeChild(mensajeDiv);
                }
            }, 300);
        }
    }, 5000);
}

// Función para limpiar formulario de entrega (puede ser llamada desde el HTML)
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

// Animaciones CSS para los mensajes
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
        
        .mensaje-exito button,
        .mensaje-error button {
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
        
        .mensaje-exito button:hover,
        .mensaje-error button:hover {
            opacity: 1;
        }
        
        /* Estilos para mejorar la apariencia de los modales */
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
    `;
    document.head.appendChild(estiloAnimaciones);
}