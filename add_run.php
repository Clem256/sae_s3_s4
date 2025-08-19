<?php
// Inclusion des fichiers nécessaires
require_once "includes/header.php";
require_once "includes/bdd_function.php";
require_once "includes/function.php";
$pseudo = $_SESSION['pseudo'];
$status = "attente";
$game = $_GET['game'] ?? "";
$id = get_game_id($game);

$ListCategorie = get_Categorie($id);
// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST["game"]) && !empty($_POST["vid"])
        && !empty($_POST["ver"]) && !empty($_POST["cat"]) && !empty($_POST["tps"])
        && !empty($_POST["plat"]) && !empty($_POST["date"])) {

        // Récupération des données du formulaire
        $lien = trim($_POST['vid']);
        $time = trim($_POST['tps']);
        $version = trim($_POST["ver"]);
        $plateforme = trim($_POST["plat"]);
        $date = trim($_POST["date"]);

        // Récupère l'id du jeu
        $jeu = get_game_id($_POST['game']);
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
            echo "Une erreur s'est produite lors de l'insertion : " . $e->getMessage();
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
            <label>Jeu concerné :</label>
            <input type="text" id="game-search" placeholder="Rechercher un jeu...">
        </div>
        <div class="form-group">
            <label>Choix du jeu :</label>
            <select name="game" id="games-select">
                <?php
                if (empty($ListeJeu)) {
                    echo "<option>Aucun jeu disponible.</option>";
                } else {
                    foreach ($ListeJeu as $jeu): ?>
                        <option value="<?= htmlspecialchars($jeu['nom_jeu']) ?>">
                            <?= htmlspecialchars($jeu['nom_jeu']) ?>
                        </option>
                    <?php endforeach;
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label>Vidéo de la course :</label>
            <input type='text' name='vid' id='vid' placeholder='Lien de la course' required>
        </div>
        <div class="form-group">
            <label>Temps de la course :</label>
            <input type='text' name='tps' id='tps' placeholder='Temps de la course (HH:MM:SS)' required>
        </div>
        <div class="form-group">
            <label>Catégorie :
                <select name="cat" id="cat">
                    <?php if (empty($ListCategorie)): ?>
                        <option>Aucune catégorie disponible.</option>
                    <?php else: ?>
                        <?php foreach ($ListCategorie as $categorie): ?>
                            <option value="<?= htmlspecialchars($categorie['nom_cat']) ?>">
                                <?= htmlspecialchars($categorie['nom_cat']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
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
        <input type='submit' value='Publier' class='form-submit-button'>
    </form>
</div>
<?php else: ?>
    <?php header("Location: pdo.php"); ?>
<?php endif; ?>
</body>
</html>
