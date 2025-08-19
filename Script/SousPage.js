document.addEventListener('DOMContentLoaded', () => {
    const categoryItems = document.querySelectorAll('.category_page p');
    const listeRunContainer = document.querySelector('.Liste_run');
    const savedCategory = localStorage.getItem('selectedCategory');

    // Masquer le contenu au chargement
    listeRunContainer.classList.add('hidden');

    if (savedCategory) {
        fetchContent(savedCategory);
    } else {
        // Afficher le contenu si aucune catégorie n'est enregistrée
        listeRunContainer.classList.remove('hidden');
    }

    categoryItems.forEach(item => {
        item.addEventListener('click', () => {
            const category = item.getAttribute('data-category');
            localStorage.setItem('selectedCategory', category);
            fetchContent(category);
        });
    });

    function fetchContent(category) {
        fetch(`get_content.php?category=${encodeURIComponent(category)}&id=${encodeURIComponent(gameId)}`)
            .then(response => response.text())
            .then(data => {
                listeRunContainer.innerHTML = data;
                // Afficher le contenu une fois chargé
                listeRunContainer.classList.remove('hidden');
            })
            .catch(err => console.error('Erreur:', err));
    }
});