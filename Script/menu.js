const fermerMenu = () => {
    const input = document.getElementById('menu-cb');
    input.checked = false;

    const fenetreNode = document.getElementById('menu-cote');
    if (fenetreNode) {
        fenetreNode.remove();
    }
};

const changerEtatMenu = () => {
    // Récupérer la case à cocher
    const input = document.getElementById('menu-cb')
    // Récupérer l'état de la case
    const actif = input.checked

    // Si le menu est affiché
    if (actif) {
        // Ajouter un élément transparent
        const fenetreNode = document.createElement('div')
        fenetreNode.id = 'menu-cote'
        fenetreNode.className = 'menu-cote'
        fenetreNode.style.filter = brightness(1.75);
        // Ecouter lorsque le visiteur clique dessus
        fenetreNode.addEventListener('click', fermerMenu)

        // Ajouter l'élément à la page
        document.body.appendChild(fenetreNode)
    } else {
        // ... sinon ...
        // Supprimer l'élément fictif ajouté à l'ouverture du menu
        const fenetreNode = document.getElementById('menu-cote')
        fenetreNode.remove()
    }
}

// Ecouter lorsque le visiteur clique sur le menu
const input = document.getElementById('menu-cb')
input.addEventListener('click', changerEtatMenu)

document.addEventListener('DOMContentLoaded', () => {
    const menuCb = document.getElementById('menu-cb');
    const menuNav = document.querySelector('.menu-nav');

    menuCb.addEventListener('change', () => {
        if (menuCb.checked) {
            menuNav.style.display = 'block';
        } else {
            menuNav.style.display = 'none';
        }
    });
});