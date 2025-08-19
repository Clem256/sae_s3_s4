<?php
// Inclusion des fichiers nécessaires
require_once "includes/header.php";
require_once "includes/bdd_function.php";
require_once "includes/function.php";
$pseudo = $_SESSION['pseudo'];
$id_jeu = $_SESSION['idJeu'];
$status = "attente";

$ListCategorie = get_Categorie2($id_jeu);
// Traitement du formulaire

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST["vid"])
        && !empty($_POST["ver"]) && !empty($_POST["cat"]) && !empty($_POST["tps"])
        && !empty($_POST["plat"]) && !empty($_POST["date"])) {
        unset($_SESSION['idJeu']);

        // Récupération des données du formulaire
        $lien = trim($_POST['vid']);
        $time = trim($_POST['tps']);
        $version = trim($_POST["ver"]);
        $plateforme = trim($_POST["plat"]);
        $date = trim($_POST["date"]);

        // Récupère l'id du jeu
        $jeu = $id_jeu;
        if (!$jeu) {
            echo "Erreur : Jeu non trouvé.";
            exit;
        }
        // Récupère la catégorie de la run
        $categorie = getCategorie_id($_POST['cat']);
        if (!$categorie) {
            echo "Erreur : Catégorie non trouvée.";
            exit;
        }
        $id = get_user_id($pseudo) ?? "Erreur";
        $game = get_game_by_id($jeu);
        $id_jeu = $game['id_jeu'] ?? "Erreur";
        $id_cate = get_Categorie_by_name($categorie);
        $id_run = get_run_id($lien);
        try {
            insert_run($pseudo, $time, $date, $plateforme, $version, $categorie, $jeu, $lien);
            insert_etat($id_jeu, $categorie, $id_run, $id, $status);
            echo "La run a été enregistrée avec succès.";
        } catch (Exception $e) {
        }
    } else {
        echo "Veuillez remplir tous les champs obligatoires.";
    }
}

$ListeJeu = get_game();

?>
<?php if (is_user_connected()) : ?>
<html>
<head>
    <?php if (is_user_connected()): ?>
        <link rel="stylesheet" href="style/CSS/style.php?version=<?php echo time(); ?>">
    <?php else: ?>
        <link rel="stylesheet" href="style/CSS/style.css?v=1.0">
    <?php endif; ?>
    <title>Ajouter une Run</title>
</head>
<body>
<div class='form-container'>
    <h1>Veuillez renseigner les informations de votre course</h1>
    <form method='post' action=''>
        <div class="form-group">
            <label>Pseudo du joueur :</label>
            <input type='text' name='pseudo' id='pseudo' placeholder='<?= $pseudo ?>' disabled="disabled">
        </div>
        <div class="form-group">
            <label>Vidéo de la course :</label>
            <input type='text' name='vid' id='vid' placeholder='Lien de la course' required>
        </div>
        <div class="form-group">
            <label>Temps de la course :</label>
            <input type='time' step="1" name='tps' id='tps' placeholder='Temps de la course (HH:MM:SS)' required>
        </div>
        <div class="form-group">
            <label class="pour">Catégorie :
                <input type="text" name="cat" id="search-category" list="category-options" placeholder="Recherche d'une catégorie...">
                <datalist id="category-options">
                    <?php if (empty($ListCategorie)): ?>
                        <option>Aucune catégorie disponible.</option>
                    <?php else: ?>
                        <?php foreach ($ListCategorie as $categorie): ?>
                            <option value="<?= htmlspecialchars($categorie['nom_categorie']) ?>">
                                <?= htmlspecialchars($categorie['nom_categorie']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </datalist>
            </label>

        </div>
        <div class="form-group">
            <label>Date :</label>
            <input type='date' name='date' id='date' required>
        </div>
        <div class="form-group">
            <label>Plateforme :</label>
            <input type='text' name='plat' id='plat' placeholder='Plateforme' required>
        </div>
        <div class="form-group">
            <label>Version :</label>
            <input type='text' name='ver' id='ver' placeholder='Version du jeu' required>
        </div>
        <button type="submit" id="submit-button">envoyer</button>
    </form>
</div>
<?php else: ?>
    <?php header("Location: pdo.php"); ?>
<?php endif; ?>
</body>
</html>
<?php require_once "includes/footer.php"; ?>

<style>
    body {
        background-color: #f1f1f1;
    }
    @media (min-width: 891px) {
        .form-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            margin: auto;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 100%;
            max-width: 600px;
        }

        form label {
            display: flex;
            flex-direction: column;
            font-size: 1.1rem;
            font-weight: 600;
            line-height: 1.4;
        }

        form select,
        form input[type="file"],
        form button,
        form input[type="text"],
        form input[type="date"] {
            font-size: 1rem;
            padding: 10px;
            width: 100%;
        }


        form button {
            padding: 12px;
            border: none;
        }

        form button:hover {
            transform: scale(1.02);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .pour {
            display: flex;
            flex-direction: column;
            margin-top: 10px;
        }

        .pour input[type="text"] {
            padding: 10px;
            width: 100%;
        }
        .pour option {
            padding: 10px;
        }
    }
    @media (min-width: 300px) and (max-width: 890px) {
        .form-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            margin: auto;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 100%;
            max-width: 600px;
        }

        form label {
            display: flex;
            flex-direction: column;
            font-size: 1.1rem;
            font-weight: 600;
            line-height: 1.4;
        }

        form select,
        form input[type="file"],
        form button,
        form input[type="text"],
        form input[type="date"] {
            font-size: 1rem;
            padding: 10px;
            width: 100%;
        }


        form button {
            padding: 12px;
            border: none;
        }

        form button:hover {
            transform: scale(1.02);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .pour {
            display: flex;
            flex-direction: column;
            margin-top: 10px;
        }

        .pour input[type="text"] {
            padding: 10px;
            width: 100%;
        }
        .pour option {
            padding: 10px;
        }
    }
    @media (max-width: 891px) {
        .form-group {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }

        .form-group label {
            flex: 1;
            margin-right: 10px;
        }

        .form-group input[type="text"],
        .form-group datalist {
            flex: 2;
        }
        .form-group input[type="date"] {
            flex: 2;
        }
    }
    input[type="time"] {
        font-size: 1rem;
        padding: 10px;
        width: 100%;
        border: 2px solid #007BFF;
        border-radius: 5px;
        background-color: #f9f9f9;
        color: #333;
        outline: none;
    }

    input[type="time"]:hover {
        border-color: #0056b3;
    }

    input[type="time"]:focus {
        border-color: #28a745;
        background-color: #fff;
        box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
    }

</style>
