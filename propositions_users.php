<?php
require_once "includes/header.php";
require_once "includes/bdd_function.php";
require_once "includes/function.php";

$ListeJeu = get_game();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST["desc"]) && !empty($_POST["add"]) && isset($_POST["game"])) {
        $desc = $_POST["desc"];
        $add = $_POST["add"];
        $title = $_POST["title"];
        $jeu = $_POST["game"] ?? "";
        $guide = $_FILES['guide'] ?? null;
        $guidePath = '';

        if ($guide && $guide['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'Guide/';
            $addPath = 'admin/Guide/';
            $uploadFile = $uploadDir . basename($guide['name']);
            $addPath = $addPath . basename($guide['name']);
            if (move_uploaded_file($guide['tmp_name'], $addPath)) {
                $guidePath = $uploadFile;
            } else {
                exit;
            }
           move_uploaded_file($guide['tmp_name'], $uploadFile);

        }

        try {
            $id_jeu = get_game_id($jeu);
        } catch (DatabaseException $e) {
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }

        try {
            add_user_idea($desc,$title ,  $add, $id_jeu, $guidePath);
        } catch (DatabaseException $e) {
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }
}

if (!is_user_connected()) {
    header('Location: pdo.php');
    exit();
}

$pseudo = $_SESSION['pseudo'];
?>
<link rel="stylesheet" href="style/CSS/style.php?version=<?php echo time(); ?>">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<body>
<div class='form-container'>
    <h1>Renseigner votre proposition d'ajout</h1>
    <form method='post' action='' enctype="multipart/form-data">
        <label>Ajout de :
            <select name="add" id="add-select">
                <option value="null">--Please choose an option--</option>
                <option value="Categorie">Categorie</option>
                <option value="Jeu">Jeu</option>
                <option value="Guide">Guide</option>
            </select>
        </label>
        <label class="pour" style="display: none;"> Pour :
            <input type="text" name="game" id="search-game" list="game-options" placeholder="Recherche d'un jeu...">
            <datalist id="game-options">
                <?php foreach ($ListeJeu as $jeu) { ?>
                    <option value="<?php echo $jeu['nom_jeu']; ?>"><?php echo $jeu['nom_jeu']; ?></option>
                <?php } ?>
            </datalist>
        </label>
        <label>Titre : </label>
        <input type="text" name="title">
        <input type="file" name="guide" id="guide-file" style="display: none;">
        <label>Brève description : </label>
        <textarea name="desc" id="desc" cols="30" rows="10" placeholder="Description"></textarea>
        <input type='text' name='desc' id='desc' placeholder='Description'>
        <button type="submit">envoyer</button>
    </form>
</div>
</body>

<style>
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
        box-sizing: border-box;
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
    form button {
        font-size: 1rem;
        padding: 10px;
        border: 1px solid #ccc;
        width: 100%;
    }
    form input[type="text"] ,
    form textarea {
        border: 1px solid #ccc;
        width: 100%;
        padding: 10px;
        line-height: 1.5;
        vertical-align: top;
    }
    form input[type="text"] {

    }

    form button {
        font-size: 1rem;
        padding: 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    form button:hover {
        transform: scale(1.02);
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }

    .pour {
        margin-top: 10px;
    }

</style>

<script>
    const select = document.getElementById('add-select');
    const file = document.getElementById('guide-file');
    const pour = document.querySelector('.pour');

    select.addEventListener('change', (e) => {
        const value = e.target.value;
        if (value === 'null' || value === 'Jeu') {
            pour.style.display = 'none';
            file.style.display = 'none';
        } else if (value === 'Guide') {
            pour.style.display = 'block';
            file.style.display = 'block';
        } else {
            pour.style.display = 'block';
            file.style.display = 'none';
        }
    });
</script>
