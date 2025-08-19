document.addEventListener('DOMContentLoaded', () => {
    const profileItems = document.querySelectorAll('.user_sous_page p');
    const contentContainer = document.querySelector('.content');
    profileItems.forEach(item => {
        item.addEventListener('click', () => {
            const category = item.getAttribute('data-category');
            fetch(`get_profile_content.php?category=${encodeURIComponent(category)}&id=${encodeURIComponent(id_user)}`)
                .then(response => response.text())
                .then(data => {
                    contentContainer.innerHTML = data;
                })
                .catch(err => {
                    console.error('Erreur:', err);
                    contentContainer.innerHTML = '<p>Erreur lors du chargement du contenu.</p>';
                });
        });
    });
});
