<?php
require_once './includes/bdd_function.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['commentaire']) && !empty($_POST['id_post'])) {
        $contenu_commentaire = htmlspecialchars($_POST['commentaire']);
        $id_post = htmlspecialchars($_POST['id_post']);
        try {
            add_commentaire($contenu_commentaire, $_SESSION['id'], $id_post);
        } catch (DatabaseException $e) {

        }
    }
}
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
