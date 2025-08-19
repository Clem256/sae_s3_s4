document.addEventListener('DOMContentLoaded', function () {
    const filterSelect = document.getElementById('filterSelect');
    const filtreInput = document.getElementById('filtre');

    if (filterSelect && filtreInput) {
        filterSelect.addEventListener('change', function () {
            const selectedOption = filterSelect.options[filterSelect.selectedIndex].text;
            filtreInput.placeholder = selectedOption;
        });
    }
});
document.addEventListener('DOMContentLoaded', () => {
    const filterSelect = document.getElementById('filterSelect');
    const inputField = document.getElementById('filtre');

    filterSelect.addEventListener('change', () => {
        const selectedFilter = filterSelect.value;
        let placeholderText = 'Filtre...';

        switch (selectedFilter) {
            case 'Joueur':
                placeholderText = 'Joueur...';
                break;
            case 'IGT':
                placeholderText = 'IGT...';
                break;
            case 'Date':
                placeholderText = 'Date...';
                break;
            case 'Plateforme':
                placeholderText = 'Plateforme...';
                break;
            case 'Version':
                placeholderText = 'Version...';
                break;
        }

        inputField.placeholder = placeholderText;
    });

    const listeRunContainer = document.querySelector('.Liste_run');
    let activeCategory = null;

    listeRunContainer.addEventListener('click', (event) => {
        const button = event.target;

        if (button.classList.contains('filter-btn')) {
            const filter = button.getAttribute('data-filter');

            if (activeCategory === filter) {
                activeCategory = null;
                console.log('Réinitialisation du tableau');

                fetch(`get_content.php?category=run&id=${encodeURIComponent(gameId)}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur réseau');
                        }
                        return response.text();
                    })
                    .then(data => {
                        if (data.trim()) {
                            listeRunContainer.innerHTML = data;
                        } else {
                            console.warn('Aucune donnée retournée pour la catégorie "run".');
                        }
                    })
                    .catch(err => console.error('Erreur:', err));
                return;
            }

            activeCategory = filter;

            const filterSelect = document.querySelector('select[name="filter"]');
            const filterValue = filterSelect ? filterSelect.value : '';

            const inputField = document.querySelector('#filtre');
            const inputFilter = inputField ? inputField.value : '';
            fetch(`get_content.php?category=run&id=${encodeURIComponent(gameId)}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    categorie_jeu: filter,
                    filter: filterValue,
                    filtre: inputFilter
                }).toString()
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur réseau');
                    }
                    return response.text();
                })
                .then(data => {
                    if (data.trim()) {
                        listeRunContainer.innerHTML = data;
                    } else {
                        console.warn('Aucune donnée retournée pour le filtre.');
                    }
                })
                .catch(err => console.error('Erreur:', err));
        }
    });
});