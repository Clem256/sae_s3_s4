document.addEventListener('DOMContentLoaded', function () {
    const rulesButton = document.getElementById('rulesButton');
    const rulesPopup = document.getElementById('rulesPopup');
    const closePopup = document.getElementById('closePopup');
    const rulesTitle = document.getElementById('rulesTitle');
    const rulesText = document.getElementById('rulesText');
    if (Array.isArray(gameRules) && gameRules.length > 0) {
        const rule = gameRules[0];
        console.log("Règle :", rule);

        rulesButton.addEventListener('click', function () {
            if (rule.Titre && rule.Contenu) {
                rulesTitle.textContent = rule.Titre;
                rulesText.textContent = rule.Contenu;
                rulesPopup.classList.remove('hidden');
            } else {
                rulesTitle.textContent = "Aucune règle disponible";
                rulesText.textContent = "";
            }
        });
    } else {
        console.warn("Aucune règle trouvée dans gameRules.");
    }

    closePopup.addEventListener('click', function () {
        rulesPopup.classList.add('hidden');
    });
});
