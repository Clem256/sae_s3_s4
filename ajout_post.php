<?php
require_once './includes/bdd_function.php';

session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['titre']) && !empty($_POST['contenu']) && !empty($_POST['id_jeu'])) {
        $titre_post = htmlspecialchars($_POST['titre']);
        $contenu_post = htmlspecialchars($_POST['contenu']);
        $id_jeu = htmlspecialchars($_POST['id_jeu']);
        add_post($titre_post, $contenu_post, $_SESSION['id'], $id_jeu);
    }
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>