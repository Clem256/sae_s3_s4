<?php
require_once './includes/bdd_function.php';


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (!empty($_POST['titre_mod']) && !empty($_POST['contenu_mod']) && !empty($_POST['id_post']))
    {
        $nouveau_titre_post = htmlspecialchars($_POST['titre_mod']);
        $nouveau_contenu_post = htmlspecialchars($_POST['contenu_mod']);
        $id_post = htmlspecialchars($_POST['id_post']);
        echo $nouveau_titre_post.$nouveau_contenu_post.$id_post;
        alter_post($id_post, $nouveau_titre_post, $nouveau_contenu_post);
    }
    else
    {
        echo "Zikette";
        echo $_POST['titre_mod'];
        echo $_POST['contenu_mod'];
        echo $_POST['id_post'];
    }
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>