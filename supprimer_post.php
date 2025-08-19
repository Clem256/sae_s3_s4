<?php
require_once './includes/bdd_function.php';

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (!empty($_POST['id_post_suppr']))
    {
        $post_id = htmlspecialchars($_POST['id_post_suppr']);
        suppr_post($post_id);
    }
    else
    {
        echo "Zikette";
    }
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>