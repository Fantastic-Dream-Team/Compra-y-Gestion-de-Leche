// Validación básica del formulario antes de enviar
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const username = document.getElementById('username').value;
    const codigo = document.getElementById('codigo').value;
    
    // Validación simple
    if (!email || !password || !username || !codigo) {
        e.preventDefault();
        document.getElementById('errorMessage').textContent = "Por favor completa todos los campos obligatorios.";
        document.getElementById('errorMessage').classList.add('show');
        return false;
    }
    
    // Validación de formato de email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        document.getElementById('errorMessage').textContent = "Por favor ingresa un correo electrónico válido.";
        document.getElementById('errorMessage').classList.add('show');
        return false;
    }
    
    return true;
});

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