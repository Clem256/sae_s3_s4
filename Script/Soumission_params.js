document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('settingsForm');
    const feedback = document.getElementById('feedback');

    form.addEventListener('submit', (event) => {
        event.preventDefault(); // Empêche le rechargement de la page

        // Prépare les données du formulaire
        const formData = new FormData(form);

        // Envoie les données via Fetch API
        fetch('get_profile_content.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.text()) // Traite la réponse comme du texte brut
            .then(data => {
                feedback.innerHTML = data; // Affiche la réponse dans le conteneur
            })
            .catch(error => {
                feedback.innerHTML = '<p>Erreur lors de la soumission du formulaire.</p>';
                console.error('Erreur:', error);
            });
    });
});
