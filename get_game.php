<?php
require_once "includes/bdd_function.php";
require_once "includes/header.php";
require_once "includes/function.php";

// Récupérer la liste des jeux
$ListeJeu = get_game();

// Vérifier si le formulaire est soumis
if (isset($_POST['jeuName']) && !empty($_POST['jeuName'])) {
    $jeuName = $_POST['jeuName'];
    $idJeu = get_game_id($jeuName);

    if ($idJeu) {
        $_SESSION['idJeu'] = $idJeu;
        header('Location: run.php');
        exit(); // S'assurer que le script s'arrête après redirection
    } else {
        $error = "Jeu non trouvé. Veuillez vérifier votre saisie.";
    }
}
?>
<?php if (is_user_connected()): ?>
    <link rel="stylesheet" href="style/CSS/style.php?version=<?php echo time(); ?>">
<?php else: ?>
    <link rel="stylesheet" href="style/CSS/style.css?v=1.0">
<?php endif; ?>
<body>
<form action="" method="post" class="search-form">
    <div class="form-group">
        <label for="search-game">Rechercher un jeu :</label>
        <input type="text" name="jeuName" id="search-game" list="game-options" placeholder="Entrez le jeu..." required>
        <datalist id="game-options">
            <?php foreach ($ListeJeu as $jeu): ?>
                <option value="<?php echo htmlspecialchars($jeu['nom_jeu']); ?>">
                    <?php echo htmlspecialchars($jeu['nom_jeu']); ?>
                </option>
            <?php endforeach; ?>
        </datalist>
    </div>
    <button type="submit" class="btn btn-primary">Rechercher</button>
</form>

<?php if (isset($error)): ?>
    <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
</body>

<?php require_once "includes/footer.php"; ?>

<style>
    @media (min-width: 891px) {


    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh; /* L'écran doit toujours être rempli */
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
    }

    .search-form {
        margin: auto; /* Centre le formulaire horizontalement et verticalement */
        text-align: center; /* Centre le contenu textuel du formulaire */
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
    }

    .search-form .form-group {
        margin-bottom: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .search-form label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .search-form input[type="text"] {
        padding: 10px;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 100%;
        max-width: 300px;
    }

    .search-form button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .search-form button:hover {
        background-color: #0056b3;
    }

    footer {
        max-width: 100%;
        margin-top: auto;
    }
    }
    @media (max-width: 891px) {
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        .search-form {
            margin: auto;
            text-align: center;
            padding: 20px;
            background-color: #fff;
            max-width: 90%;
            width: 100%;
        }

        .search-form .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .search-form label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .search-form input[type="text"] {
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 50%;
            max-width: 300px;
        }

        .search-form button {
            width: 100px;
            height: 50px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
        }

        .search-form button:hover {
            background-color: #0056b3;
        }

        footer {
            max-width: 100%;
            margin-top: auto;
        }
    }
</style>