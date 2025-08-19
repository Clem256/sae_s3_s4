document.addEventListener("DOMContentLoaded", () => {
    console.log("Script chargé et DOM prêt.");

    // Sélection des éléments nécessaires
    const paragraphsEn = document.querySelectorAll('.EN'); // Paragraphe(s) en anglais
    const paragraphsFr = document.querySelectorAll('.FR'); // Paragraphe(s) en français
    const btnEn = document.querySelector('.btn-en'); // Bouton pour activer l'anglais
    const btnFr = document.querySelector('.btn-fr'); // Bouton pour activer le français

    // Vérifier que tous les éléments existent avant de continuer
    if (paragraphsEn.length && paragraphsFr.length && btnEn && btnFr) {
        // Ajouter les écouteurs d'événements sur les boutons
        btnEn.addEventListener('click', () => {
            switchLanguage('EN', 'FR');
        });

        btnFr.addEventListener('click', () => {
            switchLanguage('FR', 'EN');
        });

        // Fonction pour basculer la langue
        function switchLanguage(showClass, hideClass) {
            // Afficher les éléments de la classe choisie
            document.querySelectorAll(`.${showClass}`).forEach(el => {
                el.style.display = 'block'; // Affiche les éléments sélectionnés
            });

            // Masquer les éléments de l'autre classe
            document.querySelectorAll(`.${hideClass}`).forEach(el => {
                el.style.display = 'none'; // Masque les éléments sélectionnés
            });
        }

        // Initialisation : afficher le français par défaut
        switchLanguage('FR', 'EN');
    } else {
        console.error("Certains éléments nécessaires n'ont pas été trouvés dans la page.");
    }
});
