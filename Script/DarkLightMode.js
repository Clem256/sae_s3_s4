const icon = document.getElementById("iconswitch");
// récupérer ici la Div switch, le bouton, l'icone, le container et le titre
const switchBox = document.getElementById("switch");
const button = document.querySelector(".btn");
console.log(icon);
button.addEventListener("click", changeLightDark);

function changeLightDark() {
    console.log("changé !")
    // 2 - Utiliser toggle pour changer btn, icone puis fa-moon en fa-sun
    icon.classList.toggle("icone-change");
    icon.classList.toggle("fa-sun");
    button.classList.toggle("btn-change");
    // 3 - changer aussi l'aspect de la div switch et du container
    switchBox.classList.toggle("switch-change");
    if (icon.classList.contains("fa-sun")) {
        document.body.style.backgroundColor="aliceblue";
    } else {
        document.body.style.backgroundColor="rgb(89, 93, 97)";
    }
}