document.getElementById('choix_game_cate_regle').addEventListener('change', function () {
    const jeuId = this.value;

    // Envoi de la requête AJAX
    fetch('fetch_categories.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ jeuId: jeuId }),
    })
    .then(response => response.json())
    .then(data => {
        // Mise à jour du menu des catégories
        const categorySelect = document.getElementById('choix_cate_regle');
        categorySelect.innerHTML = ''; // Vider les options existantes

        data.forEach(category => {
            const option = document.createElement('option');
            option.value = category.id;
            option.textContent = category.nom_categorie;
            categorySelect.appendChild(option);
        });
    })
    .catch(error => console.error('Erreur lors de la récupération des catégories:', error));
});
