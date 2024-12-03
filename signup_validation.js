document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('signup-form');
    form.addEventListener('submit', function(event) {
        let isValid = true;

        // Validation du nom d'utilisateur
        const username = document.getElementById('username').value.trim();
        if (username.length < 3) {
            isValid = false;
            alert('Le nom d\'utilisateur doit contenir au moins 3 caractères.');
        }

        // Validation de l'email
        const email = document.getElementById('email').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            isValid = false;
            alert('Veuillez entrer une adresse email valide.');
        }

        // Validation du mot de passe
        const password = document.getElementById('password').value;
        if (password.length < 8) {
            isValid = false;
            alert('Le mot de passe doit contenir au moins 8 caractères.');
        }

        // Vérification de la confirmation du mot de passe
        const confirmPassword = document.getElementById('confirm-password').value;
        if (password !== confirmPassword) {
            isValid = false;
            alert('Les mots de passe ne correspondent pas.');
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
});