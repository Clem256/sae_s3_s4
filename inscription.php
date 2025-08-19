<?php
require_once('pdo.php');
$user = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['mail']) && !empty($_POST['pw']) && !empty($_POST['pseudo'])) {
        $pseudo = $_POST['pseudo'];
        $mail = $_POST['mail'];
        $password = $_POST['pw'];

        // Vérifie si le pseudo existe déjà dans la BDD
        $existingUser = $user->getUserByPseudo($pseudo);

        // Si l'utilisateur n'existe pas, on l'insère dans la BD
        if (!$existingUser) {
            if (password_verify($password, $existingUser['motDePasse'])) {
                $_SESSION['connected'] = true; // Mise à jour de l'état de connexion
                $user->createUser($pseudo, $mail, $password);
                header('Location: game.php');
                exit();
            }
        }
    }
}

require_once 'includes/function.php';

?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/obLogo.png" type="image/x-icon">
    <?php if (is_user_connected()): ?>
        <link rel="stylesheet" href="style/CSS/style.php?version=<?php echo time(); ?>">
    <?php else: ?>
        <link rel="stylesheet" href="style/CSS/style.css?v=1.0">
    <?php endif; ?>
    <script src="script.js"></script>
    <title>Connexion</title>
</head>
<body>
<div class="form-container">
    <h1>Connectez-vous</h1>
    <form method="post">
        <label>Entrez vos identifiants :</label>
        <input type="text" name="pseudo" id="pseudo" placeholder="Pseudo" minlength="4" required>
        <input type="email" name="mail" id="mail" placeholder="Email" minlength="4" required>
        <input type="password" name="pw" id="pw" placeholder="Mot de passe" minlength="4" maxlength="20" required>
        <input type="submit" value="Connexion" class="form-submit-button">

        <?php if (!empty($feedback)): ?> <!-- Affiche le message de retour si présent -->
            <p><?php echo $feedback; ?></p>
        <?php endif; ?>
    </form>
</div>
</body>
</html>