<?php require_once "includes/function.php" ?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/obLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="style/CSS/connexion.css">
    <title>Réinitialisation du mot de passe</title>
</head>
<body>
<div class='form-container'>
    <h1>Réinitialisation du mot de passe</h1>
    <form method='post' action='index.php'>
        <label>Veuillez rentrer votre nouveau mot de passe</label>
        <input type='password' name='mdp' id='mdp' placeholder='Mot de passe' required>
        <label>Veuillez confirmer votre nouveau mot de passe</label>
        <input type='password' name='mdp_confirm' id='mdp_confirm' placeholder='Confirmation' required>
        <input type='submit' value='Changer le mot de passe' class='form-submit-button'>
    </form>
</div>
</body>
</html>

<?php

require_once("pdo.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['mdp']) && !empty($_POST['mdp_confirm'])) {
        $mdp = $_POST["mdp"];
        $confirm = $_POST["mdp_confirm"];

        while ($mdp !== $confirm) {
            echo "Les mots de passes sont différents. Réessayez";
        }

        $requete = "UPDATE User SET motDePasse=? where email=?";
        $result = exec_request($pdo, $requete, [$confirm, $_SESSION["email"]]);

        header('Location:pdo.php');
        exit();
    }
}


?>