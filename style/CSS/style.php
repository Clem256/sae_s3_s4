<?php

require_once "../../includes/bdd_function.php";
header("Content-Type: text/css; charset=utf-8");
session_start();

// Récupérer le pseudo utilisateur
$pseudo = $_SESSION['pseudo'] ?? '';
$name_theme = $_SESSION['theme'] ?? 'default';

// Récupérer les informations de thème de l'utilisateur
$id_joueur = get_user_id($pseudo);
$theme = get_theme_by_name($name_theme, $id_joueur);
var_dump($theme);
$background = $theme['couleur_fond'] ?? 'white';

//
//// Définir les valeurs par défaut si elles ne sont pas définies dans le thème
//$couleur_nom = $theme['couleur_nom'] ?? 'black';
//$couleur_fond = $theme['couleur_fond'] ?? 'white';
//$couleur_texte = $theme['couleur_texte'] ?? 'black';
//$image_fond = $theme['image_fond'] ?? '';

?>
<script>
    const test = "<?= $theme?>";
    console.log(test);
</script>
.EN {
display: none;
}

.FR {
display: block;
}

.checkbox-text {
display: none;
}
#game, input[type="file"] , select[name="game"] {
display: none;
}
input[type="file"] {
display: block;
margin-top: 10px;
}
@media (min-width: 300px) and (max-width: 890px) {
body {
font-size: 0.8em;
height: 100vh;
margin: 0;
background-color: <?php echo $background; ?>;
}

#filterCategorie {
display: none;
}

table th:nth-child(4),
table td:nth-child(4),
table th:nth-child(5),
table td:nth-child(5),
table th:nth-child(6),
table td:nth-child(6) {
display: none;
}


#filterSelect :nth-child(3),
#filterSelect :nth-child(4),
#filterSelect :nth-child(5) {
display: none;
}

table td:nth-child(4) {
display: none;
}

.toggle_categorie {
display: inline-block;
margin-bottom: 10px;
cursor: pointer;
}

.checkbox-text {
cursor: pointer;
display: flex;
flex-direction: row;
background-color: #333;
width: 100%;
color: white;
font-size: 20px;
}

/* Header */
.navheader {
background-color: #433633;
display: flex;
justify-content: space-between;
color: white;
}

.categorie_header .fa-heart,
.categorie_header .fa-comment,
.categorie_header .fa-bell,
.categorie_header .fa-user-circle,
.categorie_header .fa-globe,
.categorie_header .fa-moon {
display: none;
}

#website_title {
display: none;
}

.logo_site {
width: 60px;
height: auto;
}

.right > .menu-nav {
display: none;
}

display_info {
display: block;
}

.menu-nav {
display: none;
position: absolute;
top: 50px;
right: 10px;
background-color: #fff;
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
z-index: 1000;
}

header i {
display: none;
}

.user-avatar {
display: none;
}

.barrerecherche {
margin-top: 10px;
max-width: 600px;
padding: 10px;
font-size: 1.2em;
}

.menu-label, .menu-cb {
appearance: none;
display: block;
position: fixed;
height: 50px;
width: 30px;
top: 25px;
right: 10px;
z-index: 10;
font-size: 2em;
}

.menu-nav ul {
list-style: none;
padding: 0;
margin: 0;
}

.menu-nav .menu-item {
padding: 10px;
border-bottom: 1px solid #ccc;
}

.menu-nav .menu-item a {
text-decoration: none;
color: #333;
}

.menu-cb:checked + .menu-nav {
display: block;
}

/* footer */
footer {
display: flex;
flex-direction: column;
background-color: #f1f1f1;
bottom: 0;
<!--position: fixed;-->
color: black;
font-size: 10px;
<!--bottom: 0;-->
width: 100%;
}

footer .legal-links {
display: flex;
justify-content: space-between;
}

footer a {
text-decoration: none;
color: black;
}

/* user part */
.user {
background: #333;
display: flex;
align-items: center;
height: 100px;
width: 100%;
}

.user > img {
width: 75px;
height: auto;
}

/* game_page */
.en_tete_jeu {
background: grey;
height: 100px;
width: 100%;
margin: 0 auto;
}

.en_tete_jeu-change {
background: #1abc9c;
display: flex;
height: 200px;
width: 100%;
margin: 0 auto;
}

.game_img {
margin-top: 5px;
width: 50px;
height: auto;
}

.contentImg {
display: flex;
align-items: center;
width: 100%;
color : #A2AEBB;
color : black;
}

.contentImg img {
margin-right: 20px;
margin-left: 10px;
}

.category_page {
display: flex;
margin: auto;
height: auto;
width: 100%;
background: #8F857D;
}

.category_page p {
margin: 0 10px;
}

.bouton_possibilite, .CategorieSelect {
background-color: #333;
}

.CategorieSelect {
display: none;
color: white;
padding: 10px;
}

.toggle_categorie:checked + .CategorieSelect {
display: block;
}

.toggle_categorie {
margin-bottom: 10px;
cursor: pointer;
}

.popup {
position: fixed;
transform: translate(-50%, -50%);
background-color: #fff;
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
padding: 20px;
z-index: 1000;
display: flex;
flex-direction: column;
width: 400px;
max-width: 80%;
}

.hidden {
display: none;
}

.popup-content {
text-align: center;
}

.close-button {
position: absolute;
top: 10px;
right: 10px;
font-size: 20px;
cursor: pointer;
}

.stats_game_responsive {
display: flex;
flex-direction: column;

margin: 0 auto;
width: 100%;
background: white;
}

/* sous page user , partie Profil.php */
.user_sous_page {
background: grey;
display: flex;
justify-content: space-around;
height: auto;
width: 100%;
margin: 0 auto;
}

.content {
background: white;
display: flex;
align-items: center;
height: auto;
width: 100%;
}

table {
width: 100%;
border-collapse: collapse;
}

table th, table td {
border: 1px solid black;
text-align: left;
}

.avatar_usr {
width: 10px;
height: auto;
}

.biographie {
display: none;
}

/* sous page user , partie get_profile_content.php */
/* video */
.video_info {
font-size: 15px;
width: 100%;
background: white;
}

.ytp_video {
width: 375px;
height: 210px;
background: white;
}

/* formulaire run */
.form-container {
display: flex;
flex-direction: column;
align-items: flex-start;
}

.form-group {
display: flex;
align-items: center;
margin-bottom: 10px;
}

.form-group label {
width: 150px;
margin-right: 10px;
}


.form-submit-button {
display: block;
margin: 0 auto;
padding: 5px;
}

/* page accueil */
.Imgjeu {
display: grid;
grid-template-columns: repeat(1, minmax(200px, 1fr));
gap: 20px;
margin: 1rem;
}

.image-container {
text-align: center;
}

.image-jeu {
width: 300px;
height: 400px;
object-fit: cover;
transition: transform 0.3s ease;
border-radius: 10px;
}

.image-jeu:hover {
transform: scale(1.05);
}

.platform {
display: flex;
align-items: center;
}

.platform h3 {
margin-right: 10px;
}

.button-container {
display: flex;
justify-content: center;
}

/* params */
.settings {
width: 100%;
display: flex;
flex-direction: column;
justify-content: right;
}

.settings form {
display: flex;
flex-direction: column;
align-items: flex-start;
}

.settings label {
display: flex;
align-items: center;
}

.radio-container {
display: flex;
align-items: center;
}

.radio-group {
display: flex;
}
.radio-group :nth-child(1),
.radio-group :nth-child(2),
.radio-group :nth-child(3),
.radio-group :nth-child(4) {

}
/* barre de recherche */
.resultat_recherche {
display: flex;
flex-direction: row;
align-items: flex-start;
gap: 20px;
}

.filter-buttons {
display: flex;
flex-direction: column;
gap: 10px;
}
.resultat_recherche a {
text-decoration: none;
color: black;
}
.search-result {
display: flex;
flex-direction: column;
align-items: flex-start;
text-decoration: none;
}
}

@media (min-width: 891px) {
body {
height: 100vh;
margin: 0;
padding: 0;
font-family: Arial, sans-serif;
background-color: aliceblue;
color: #333;
}

.logo_site {
width: 75px;
height: auto;
}

.toggle_categorie {
position: absolute;
opacity: 0;
width: 1px;
height: 1px;
}


.navheader {
display: flex;
justify-content: space-between;
align-items: center;
padding: 10px 20px;
background-color: #433633;
color: white;
}

.navheader .left {
display: flex;
align-items: center;
gap: 10px;
}

.navheader .right {
display: flex;
align-items: center;
gap: 30px;
}

.navheader .user-avatar {
border-radius: 50px;
width: 50px;
height: auto;
}

.navheader .menu-nav {
display: flex;
align-items: center;
gap: 10px;
}

.navheader i {
font-size: 30px;
}
.categorie_header {
display: flex;
align-items: center;
margin-right: 50px;
}

.menu-item {
margin-left: auto;
}
.user-avatar {
border-radius: 20px;
width: 100px;
height: auto;
}

button, input[type=button], input[type=submit], select {
cursor: pointer;
}

.button-change {
background-color: #ff6f61;
}

.leftlogo {
font-weight: bold;
font-size: 1.2em;
}

.right {
display: flex;
align-items: center;
}

.right div, .right img {
margin-left: 15px;
}

.right img {
width: 30px;
}

.filter-grid {
display: grid;
grid-template-columns: 1fr 1fr 1fr;
gap: 20px;
align-items: start;
justify-items: start;
}

main {
max-width: 1200px;
margin: auto;
padding: 20px;
}

.filtre {
display: flex;
justify-content: space-between;
padding: 20px;
border-radius: 8px;
margin-bottom: 20px;
}

.filtre .header-options {
display: flex;
justify-content: space-between;
width: 100%;
}

.filtre .header-options > div {
flex: 1;
margin-right: 20px;
}

.filtre .header-options > div:last-child {
margin-right: 0;
}

.display_info {
display: none;
}

.filtre h3 {
margin-bottom: 5px;
color: #333;
}

.filtre select,
.filtre button {
width: 100%;
padding: 10px;
margin-bottom: 10px;
border-radius: 5px;
}

a i.fas.fa-user-circle {
color: white;
}

.filtre button {
width: auto;
align-self: flex-end;
color: white;
cursor: pointer;
transition: background 0.3s;
}

.Imgjeu {
display: grid;
grid-template-columns: repeat(6, minmax(200px, 1fr));
gap: 20px;
margin: 1rem;
}

.image-container {
text-align: center;
}

.image-jeu {
width: 100%;
height: 250px;
object-fit: cover;
border-radius: 10px;
transition: transform 0.3s ease;
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.image-jeu:hover {
transform: scale(1.05);
}

.image-container p {
margin-top: 8px;
font-weight: bold;
color: #333;
}

.category_page {
display: flex;
justify-content: space-around;
margin: auto;
width: 50%;
max-width: 1000px;
background: #8F857D;
}

.category-change {
display: flex;
justify-content: space-around;
margin: auto;
width: 50%;
max-width: 1000px;
background: #1abc9c;
}

.Liste_categorie {
display: flex;
justify-content: flex-start;
width: 100%;
text-align: left;
margin-bottom: 20px;
border: none;
box-shadow: none;
}


.Liste_categorie p {
margin: 0 10px;
padding: 0 10px;
border-right: 1px solid #000;
}

.filtre_jeu {
width: 100%;
text-align: left;
}

.header-options {
display: flex;
justify-content: left;

width: 100%;
padding: 10px;
}

.header-options .platform,
.header-options .filter-options {
display: flex;
flex-direction: column;
align-items: flex-start;
}

.header-options .filter-options {
display: flex;
flex-direction: row;
align-items: center;
gap: 0;
}

.header-options select,
.header-options input {
margin: 0;
}

.en_tete_jeu {
background: #5C5552;
display: flex;
justify-content: center;
align-items: center;
height: 200px;
width: 50%;
margin: 0 auto;
}

.en_tete_jeu-change {
background: #1abc9c;
display: flex;
justify-content: center;
align-items: center;
height: 200px;
width: 50%;
margin: 0 auto;
}

.game_img {
width: 100px;
height: auto;
}

.contentImg {
display: flex;
align-items: center;
width: 100%;
}

.contentImg img {
margin-right: 20px;
margin-left: 10px;
}

.Liste_run {
display: flex;
flex-direction: column;
align-items: center;
margin: auto;
width: 50%;
max-width: 1000px;
background-color: #A2AEBB;
}

.Liste_run-change {
display: flex;
flex-direction: column;
align-items: center;
margin: auto;
width: 50%;
max-width: 1000px;
background-color: #ff6f61;
}

.filtre_jeu {
width: 100%;
text-align: left;
}

table {
width: 100%;
border-collapse: collapse;

}
table th , td {
border: 1px solid #ddd;
padding: 10px;
text-align: center;
}
table th {
background-color: #f2f2f2;
}
table tr:hover {
background-color: #f2f2f2;
}

.navheader .left {
display: flex;
align-items: start;
gap: 10px;
}

#barrerecherche {
padding: 5px;
border: 1px solid #ccc;
border-radius: 5px;
font-size: 30px;
width: 500px;
}

.navheader .right {
display: flex;
gap: 30px;
}

i {
font-size: 30px;
text-decoration: none;
}

.category_page .category {
cursor: pointer;
}

.Liste_categorie.run-active {
display: flex;
flex-wrap: wrap;
padding: 10px;
}

.Liste_categorie.run-active p {
margin: 5px;
padding: 5px;
}

.legalsMentions {
color: black;
margin: 100px;
}

.legalsMentions > h1 + p {
text-align: center;
}

.legalsMentions > h1 {
text-align: center;
color: black;
}

.legalsMentions > h2 {
color: black;
}


canvas {
display: block;
margin: auto;
width: 700px;
height: 600px;
}

.container {
display: block;
width: auto;
}

footer {
bottom: 0;
width: 100%;
background-color: white;
color: black;
display: flex;
flex-direction: row;
align-items: normal;
max-width: 100%;
margin-top: auto;
}

footer a {
text-decoration: none;
color: black;
}

iframe {
display: block;
margin: 20px auto;
width: 560px;
height: 315px;
}

.video-details {
display: flex;
justify-content: space-between;
align-items: center;
margin-bottom: 20px;
}

.video-details p {
margin: 0;
padding: 10px;
background-color: #e9e9e9;
border-radius: 5px;
}

.video-details p:first-child {
flex: 1;
}

.video-details p:last-child {
flex: 1;
text-align: right;
}



.menu-nav ul {
text-align: left;
margin: 0;
padding: 0;
list-style: none;
left: 0;
bottom: 0;
width: 100%;
align-items: center;
justify-content: center;
}

.menu-nav .menu-item {
padding: 10px;
background-color: grey;
margin-bottom: 50px;
border-radius: 5px;
transition: background-color 0.3s ease; /* Animation pour le hover */
}
.right {
display: flex;
align-items: center;
}

.menu-item {
margin-left: auto;
}
.menu-nav .menu-item a {
color: black;
text-decoration: none;
display: block; /* Fait en sorte que l'ensemble du bloc soit cliquable */
}

.menu-nav .menu-item:hover {
background-color: grey;
}

/* retire l'affichage des checkbox */
.menu-label, .menu-cb {
appearance: none;
color : grey;
position: fixed;
height: 32px;
width: 32px;
top: 20px;
right: 30px;
}

.menu-nav {

transform: translateX(100%);
position: fixed;
top: 0;
right: 0;
height: 100%;
width: 150px;
background-color: #433633;
box-shadow: -2px 0 5px rgba(0, 0, 0, 0.3);
display: flex;
flex-direction: column;
align-items: center;
justify-content: center;
padding: 20px;
transition: transform 0.3s ease-in-out;
}

.menu-cb:checked ~ .menu-nav {
transform: translateX(0);


}
.menu-label :hover {
color: black;

}
.menu-label, .menu-cb {
z-index: 10;

}

.menu-cote {
position: fixed;
top: 0;
left: 0;
height: 100%;
width: 100%;
background-color: rgba(0, 0, 0, 0.5);
z-index: 5;
}

.popup {
position: fixed;
top: 50%;
left: 50%;
transform: translate(-50%, -50%);
background-color: #fff;
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
padding: 20px;
z-index: 1000;
display: flex;
flex-direction: column;
width: 400px;
max-width: 80%;
}

.hidden {
display: none;
}

.popup-content {
text-align: center;
}

.close-button {
position: absolute;
top: 10px;
right: 10px;
font-size: 20px;
cursor: pointer;
}

.error_404 {
width: 1000px;
margin: 0 auto;
display: flex;
justify-content: center;
align-items: center;
text-align: center;
height: auto;
}

.container {
display: block;
width: auto;
}

.user {
background: grey;
display: flex;
align-items: center;
height: 200px;
width: 50%;
margin: 0 auto;
}

.user > img {
width: 150px;
height: auto;
}

.user_sous_page {
background: white;
display: flex;
justify-content: space-around;
align-items: center;
height: 25px;
width: 50%;
margin: 0 auto;
}

.settings {
position: relative;
display = flex:
flex-direction = column;
width: 100%;
}

.content {
background: grey;
display: flex;
align-items: center;
height: auto;
width: 50%;
margin: 0 auto;
}

.settings-title {
color: black;
text-align: left;
}
.settings-format {
display: flex;
align-items: center;
gap: 10px;
}

.same-line {
display: flex;
align-items: center;
gap: 10px;
}

.forum_post {
background-color: #ff6f61;
flex: 0 1 calc(50% - 20px);
}

.forum_post:hover {
transform: scale(1.1);
}

.search-form {
background-color: #fff;
padding: 20px;
border-radius: 8px;
box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
width: 100%;
max-width: 400px;
text-align: center;
}

.search-form .form-group {
margin-bottom: 15px;
text-align: left;
}

.search-form label {
font-weight: bold;
margin-bottom: 5px;
display: block;
}

.search-form input[type="text"] {
width: 100%;
padding: 10px;
border: 1px solid #ddd;
border-radius: 5px;
font-size: 1em;
}

.search-form button {
background-color: #007bff;
color: #fff;
padding: 10px 15px;
border: none;
border-radius: 5px;
font-size: 1em;
cursor: pointer;
transition: background-color 0.3s ease;
}

.search-form button:hover {
background-color: #0056b3;
}
.forum_post p, .forum_post h3 {
user-select: none;
display: flex;
flex-wrap: wrap;
gap: 20px;
justify-content: space-between;
justify-content: center;
padding: 20px;
}
.game-list-container {
display: flex;
align-items: center;
gap: 10px; /* Optionnel : ajoute un espace entre les éléments */
}
.post_display
.post_display, .creation_post {
display: none;
flex-direction: column;
align-items: center;
padding: 20px;
background-color: #ff6f61;
border: 2px solid #a53d2a;
border-radius: 10px;
box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
max-width: 600px;
margin: 0 auto;
}

#post_bouton_retour, .bouton_creation_post {
background-color: #a53d2a;
border: none;
padding: 10px 15px;
font-size: 1rem;
border-radius: 5px;
cursor: pointer;
transition: background-color 0.2s ease;
margin-bottom: 20px;
}

#post_bouton_retour:hover, .bouton_creation_post:hover {
background-color: #7f2f20;
}

.formulaire_commentaire {
display: flex;
flex-direction: column;
gap: 10px;
margin-top: 20px;
width: 100%;
}

.formulaire_commentaire input[type="text"] {
padding: 10px;
font-size: 1rem;
width: 100%;
}

.formulaire_commentaire input[type="submit"], .formulaire_post input[type="submit"] {
background-color: #a53d2a;
border: none;
padding: 7px;
font-size: 1rem;
border-radius: 5px;
cursor: pointer;
transition: background-color 0.2s ease;
}

.formulaire_commentaire input[type="submit"]:hover, .formulaire_post input[type="submit"]:hover {
background-color: #7f2f20;
}

.commentaires_container {
width: 100%;
margin-top: 20px;
background-color: #ff6f61;
padding: 10px;
}


.commentaire p {
margin: 0;
font-size: 0.7rem;
}

.formulaire_post {
display: flex;
flex-direction: column;
gap: 15px;
}

.formulaire_post label {
font-size: 16px;
}

.formulaire_post input[type="text"], .formulaire_post input[type="submit"] {
padding: 10px;
font-size: 16px;
outline: none;
}

.formulaire_post input[type="text"]:focus {
border-color: #007bff;
background-color: #e9f1ff;
}

.avatar-image {
width: 100px;
height: 100px;
border-radius: 50%;
object-fit: cover;
}
.radio-container {
display: flex;
align-items: center;
gap: 10px;
}

.radio-group {
display: flex;
gap: 10px;
}
/* CSS POUR LES FORUMS */

.forum_post
{
background-color: #ff6f61;
border-radius: 10px;
width: 300px;
height: 150px;
border: 3px solid #a53d2a;
padding: 10px;
box-sizing: border-box;
flex: 0 1 calc(50% - 20px);
word-break: break-word;
}

.forum_post:hover
{
transform: scale(1.1);
cursor: pointer;
}

.forum_post p, .forum_post h3
{
user-select: none;
}

.posts_area
{
display: flex;
flex-wrap: wrap;
gap: 20px;
justify-content: center;
padding: 20px;
}

.post_display, .creation_post, .alter_post
{
display: none;
flex-direction: column;
align-items: center;
padding: 20px;
background-color: #ff6f61;
border: 2px solid #a53d2a;
border-radius: 10px;
box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
max-width: 600px;
margin: 0 auto;
word-break: break-word;
}

#post_bouton_retour, .bouton_creation_post, .post_bouton_suppr, .post_bouton_mod
{
background-color: #a53d2a;
border: none;
padding: 10px 15px;
font-size: 1rem;
border-radius: 5px;
cursor: pointer;
transition: background-color 0.2s ease;
margin-bottom: 20px;
margin: 2px
}

.boutons_alter
{
display: none;
}

#post_bouton_retour:hover, .bouton_creation_post:hover, .post_bouton_suppr:hover, .post_bouton_mod:hover
{
background-color: #7f2f20;
}

.formulaire_commentaire
{
display: flex;
flex-direction: column;
gap: 10px;
margin-top: 20px;
width: 100%;
}

.formulaire_commentaire input[type="text"]
{
padding: 10px;
font-size: 1rem;
width: 100%;
}

.formulaire_commentaire input[type="submit"], .formulaire_post input[type="submit"]
{
background-color: #a53d2a;
border: none;
padding: 7px;
font-size: 1rem;
border-radius: 5px;
cursor: pointer;
transition: background-color 0.2s ease;
}

.formulaire_commentaire input[type="submit"]:hover, .formulaire_post input[type="submit"]:hover
{
background-color: #7f2f20;
}

.commentaires_container
{
width: 100%;
margin-top: 20px;
background-color: #ff6f61;
padding: 10px;
}


.commentaire p
{
margin: 0;
font-size: 0.7rem;
}

.formulaire_post
{
display: flex;
flex-direction: column;
gap: 15px;
}

.formulaire_post label
{
font-size: 16px;
}

.formulaire_post input[type="text"], .formulaire_post input[type="submit"]
{
padding: 10px;
font-size: 16px;
outline: none;
}

}

/* CSS POUR LES FORUMS */

.forum_post
{
background-color: lightblue;
border-radius: 10px;
width: 400px;
height: 200px;
border: 3px solid black;
padding: 10px;
box-sizing: border-box;
flex: 0 1 calc(50% - 20px);
word-break: break-word;

}

.forum_post:hover
{
transform: scale(1.1);
cursor: pointer;
border: 3px solid black;

}

.forum_post p, .forum_post h3
{
user-select: none;
}

.posts_area
{
display: flex;
flex-wrap: wrap;
gap: 20px;
justify-content: center;
padding: 20px;
}

.post_display, .creation_post, .alter_post
{
display: none;
flex-direction: column;
align-items: center;
padding: 20px;
background-color: lightblue;
border-radius: 10px;
box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
max-width: 600px;
margin: 0 auto;
word-break: break-word;
}

#post_bouton_retour, .bouton_creation_post, .post_bouton_suppr, .post_bouton_mod
{
background-color: lightblue;
border: none;
padding: 10px 15px;
font-size: 1rem;
border-radius: 5px;
cursor: pointer;
transition: background-color 0.2s ease;
margin-bottom: 20px;
margin: 2px
}

.boutons_alter
{
display: none;
}

#post_bouton_retour:hover, .bouton_creation_post:hover, .post_bouton_suppr:hover, .post_bouton_mod:hover
{
background-color: lightblue;
}

.formulaire_commentaire
{
display: flex;
flex-direction: column;
gap: 10px;
margin-top: 20px;
width: 100%;
}

.formulaire_commentaire input[type="text"]
{
padding: 10px;
font-size: 1rem;
width: 100%;
}

.formulaire_commentaire input[type="submit"], .formulaire_post input[type="submit"]
{
background-color: lightblue;
border: none;
padding: 7px;
font-size: 1rem;
border-radius: 5px;
cursor: pointer;
transition: background-color 0.2s ease;
}

.formulaire_commentaire input[type="submit"]:hover, .formulaire_post input[type="submit"]:hover
{
background-color: white;
}

.commentaires_container
{
width: 100%;
margin-top: 20px;
background-color: white;
padding: 10px;
}


.commentaire p
{
margin: 0;
font-size: 0.7rem;
}

.formulaire_post
{
display: flex;
flex-direction: column;
gap: 15px;
}

.formulaire_post label
{
font-size: 16px;
}

.formulaire_post input[type="text"], .formulaire_post input[type="submit"]
{
padding: 10px;
font-size: 16px;
outline: none;
}

