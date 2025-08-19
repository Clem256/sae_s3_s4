<?php
require_once "includes/bdd_function.php";
require_once "includes/Classe/User.php";
require_once "includes/function.php";
//require_once "includes/header.php";
// Connexion à la BDD
$conn = get_bdd_connection();
$user = new User($conn);
$feedback = ''; // Messages de retour pour l'utilisateur

if (isset($_SESSION['connected']) && $_SESSION['connected']) {
    header('Location: Profil.php?nom_utilisateur=' . $_SESSION['pseudo']);
    exit();
}
$_SESSION["connected"] = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['tries'] = 3;
    //si l'utilisateur souhaite s'inscrire
    if (!empty($_POST['mail_ins']) && !empty($_POST['pw_ins']) && !empty($_POST['pseudo_ins'])) {
        $pseudo = $_POST['pseudo_ins'] ?? '';
        $mail = $_POST['mail_ins'];
        $password = $_POST['pw_ins'];

        // Vérifie si le pseudo existe déjà dans la BDD
        $existingUser = $user->getUserByPseudo($pseudo);

        // Si l'utilisateur n'existe pas, on l'insère dans la BD
        if (!$existingUser) {
            $user->createUser($pseudo, $mail, $password);
            $id_joueur = get_user_id($pseudo);
//            $_SESSION['connected'] = true; // Mise à jour de l'état de connexion
            create_params($id_joueur);
            header('Location: index.php');
            exit();
        } else {
            echo "pseudo déjà pris";
        }

        //si l'utilisateur choisit de se connecter
    } else if (!empty($_POST['pw']) && !empty($_POST['pseudo'])) {
        $pseudo = $_POST['pseudo'];

        //éviter les injections SQL et XSS
        $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = $_POST['pw']; // Traité plus tard pour le hash

        // Vérifie si le pseudo existe déjà dans la BDD
        $existingUser = $user->getUserByPseudo($pseudo);

        //initialise le nb de tentatives de mdp
        if (!isset($_SESSION['tries'])) {
            $_SESSION['tries'] = 3;
        }

        //si plus de tentatives, redirection vers la page de mdp oublié
        if ($_SESSION['tries'] <= 0) {
            header('Location: mdp_forget.php');
            exit();
        } elseif ($existingUser) {
            if (password_verify($password, $existingUser['mot_de_passe'])) {
                $_SESSION['connected'] = true; // Mise à jour de l'état de connexion
                $_SESSION["id"] = $existingUser['id_utilisateur'];
                $_SESSION["pseudo"] = $existingUser['nom_utilisateur'];
                $_SESSION["avatar_url"] = $existingUser['avatar_url'];
                $_SESSION['role'] = $existingUser['admin'];
                $requete = "SELECT * FROM utilisateur WHERE nom_utilisateur = ? OR email = ?";
                header('Location: index.php');
                exit();
            } else {
                $feedback = "Mot de passe incorrect.";
                $_SESSION["tries"]--;
            }
        } else {
            echo "Veuillez créer un compte d'abord";
        }
    } else {
        $feedback = "Veuillez remplir tous les champs indiqués."; // Message d'erreur pour les champs vides
    }
}
?>
<script>
    let val = <?php echo json_encode($existingUser);?>;
    console.log(val);
</script>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/obLogo.png" type="image/x-icon">
    <?php if (is_user_connected()): ?>
        <link rel="stylesheet" href="style/CSS/style.php?version=<?php echo time(); ?>">
    <?php else: ?>
        <link rel="stylesheet" href="style/CSS/connexion.css?v=1.0">
    <?php endif; ?>
    <title>Connexion</title>
</head>
<body>
<!-- Conteneur global pour les deux formulaires -->
<div class="forms-container">
    <!-- Formulaire d'inscription -->
    <div class="form-container">
        <h1>Inscrivez-vous</h1>
        <form method="post">
            <label>Entrez vos identifiants :</label>
            <input type="text" name="pseudo_ins" id="pseudo_ins" placeholder="Pseudo" minlength="4" required>
            <input type="email" name="mail_ins" id="mail_ins" placeholder="Email" minlength="4" required>
            <input type="password" name="pw_ins" id="pw_ins" placeholder="Mot de passe" minlength="4" maxlength="20"
                   required>
            <input type="submit" value="Inscription" class="form-submit-button">

            <?php if (!empty($feedback)): ?> <!-- Affiche le message de retour si présent -->
                <p><?php echo $feedback; ?></p>
            <?php endif; ?>
        </form>
    </div>
    <!-- Formulaire de connexion -->
    <div class="form-container">
        <h1>Connectez-vous</h1>
        <form method="post">
            <label>Entrez vos identifiants :</label>
            <input type="text" name="pseudo" id="pseudo" placeholder="Pseudo" minlength="4" required>
            <input type="password" name="pw" id="pw" placeholder="Mot de passe" minlength="4" maxlength="20" required>
            <a href="mdp_forget.php">Mot de passe oublié ?</a>
            <a href="reset_password.php">Changement de mot de passe ?</a>
            <input type="submit" value="Connexion" class="form-submit-button">

            <?php if (!empty($feedback)): ?> <!-- Affiche le message de retour si présent -->
                <p><?php echo $feedback; ?></p>
            <?php endif; ?>
        </form>
    </div>
</div>
</body>
</html>

