<?php require_once 'includes/function.php'; ?>
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
    <title>Mot de Passe Oublié</title>
</head>
<body>
<div class='form-container'>
    <h1>Veuillez rentrer votre email</h1>
    <form method='post' action='index.php'>
        <label>Email :</label>
        <input type='email' name='mail' id='mail' placeholder='Email' required>
        <input type='submit' value='Connexion' class='form-submit-button'>
    </form>
</div>
</body>
</html>

<?php
require_once("pdo.php");

function exec_request($pdo, $request, $params = [])
{
    try {
        $stmt = $pdo->prepare($request);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        die("Erreur dans la requête : " . $e->getMessage());
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['mail'])) {
        //eviter les injections SQL et XSS
        $mail = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL);

        //verif du mail
        if (!$mail) {
            die("Adresse email invalide.");
        }

        // vérifie si l'utilisateur existe
        $requete = "SELECT id FROM utilisateur WHERE email = ?";
        $result = exec_request($pdo, $requete, [$mail]); //le $pdo est un attribut de User

        if ($result->row_count() > 0) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $user_id = $row['id'];

            // génère le token de réinitialisation
            $token = bin2hex(random_bytes(16));
            $expires_at = date("Y-m-d H:i:s", strtotime('+1 hour')); // Token expires in 1 hour

            // enregistre le token et son expiration
            $insert_token_query = "INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)";
            $insert_result = exec_request($pdo, $insert_token_query, [$user_id, $token, $expires_at]);
            if (!$insert_result) {
                die("Erreur lors de l'enregistrement du token.");
            }

            // lien du reset du mdp
            $reset_link = "https://speedrun.com/reset_password.php?token=" . $token;
            $subject = "Mot de Passe oublié";
            $message = "Bonjour, veuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe : " . $reset_link;

            // envoie l'email
            $headers = "From: no-reply@speedrun.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            mail($mail, $subject, $message, $headers);

            header('Location: ./pdo.php');
            exit();
        } else {
            die("Auncun utilisateur trouvé pour ce mail");
        }
    }
}
?>