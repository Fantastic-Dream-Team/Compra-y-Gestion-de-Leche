// login.js modificado
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const codigo = document.getElementById('codigo').value;
            
            // Validación simple
            if (!username || !password || !codigo) {
                e.preventDefault();
                document.getElementById('errorMessage').textContent = "Por favor completa todos los campos obligatorios.";
                document.getElementById('errorMessage').classList.add('show');
                return false;
            }
            
            // Validar longitud mínima de contraseña
            if (password.length < 4) {
                e.preventDefault();
                document.getElementById('errorMessage').textContent = "La contraseña debe tener al menos 4 caracteres.";
                document.getElementById('errorMessage').classList.add('show');
                return false;
            }
            
            return true;
        });
    }
    
    // Ocultar mensaje de error al empezar a escribir
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            const errorMessage = document.getElementById('errorMessage');
            if (errorMessage && errorMessage.classList.contains('show')) {
                errorMessage.classList.remove('show');
            }
        });
    });
});