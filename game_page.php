<script src="Script/DarkLightMode.js"></script>
<script src="Script/SousPage.js"></script>
<script src="Script/Game_categorie.js"></script>
<script src="Script/GamePage_filtre.js"></script>
<script src="Script/Rules_Popup.js"></script>
<script src="Script/PostsForums.js"></script>
<?php
require_once './includes/header.php';
require_once './includes/Classe/game.php';
require_once './includes/bdd_function.php';
require_once './includes/function.php';

?>
<?php if (is_user_connected()): ?>
    <link rel="stylesheet" href="style/CSS/style.php?version=<?php echo time(); ?>">
<?php else: ?>
    <link rel="stylesheet" href="style/CSS/style.css?v=1.0">
<?php endif; ?>
<?php
require_once 'get_content.php';
$videos = get_videos();

if (isset($_GET['id']) && isset($_GET['nom_jeu']) && isset($_GET['image_url'])) {
    $id = intval($_GET['id']);
    $nom = $_GET['nom_jeu'];
    $image_url = urldecode($_GET['image_url']);
    $games = creergame($id, $nom, $image_url);
    if (isset($games[$id])) {
        $game = $games[$id];
        $nom = $game->getName();
        $img = $game->getImageUrl();
    } else {
        echo "Jeu non trouvé.";
        exit;
    }
} else {
    echo "ID de jeu ou URL de l'image incorrect.";
    exit;
}
$CategoryList = get_game_categorie_by_id($id);
$defaultCategory = $CategoryList[0]['nom_categorie'] ?? '';

$placeholer = 'Joueur...';
$params = '';
$categorie = 'Joueur';
$ButtonValue = $defaultCategory;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['filter']) && !empty($_POST['filter'])) {
        $categorie = $_POST['filter'];
    }

    if (isset($_POST['filtre']) && !empty($_POST['filtre'])) {
        $params = $_POST['filtre'];
    }
    $idCategorie = '';
    if (isset($_POST['categorie_jeu']) && !empty($_POST['categorie_jeu'])) {
        $ButtonValue = $_POST['categorie_jeu'];
    }
}

try {
    $idCategorie = getCategorie_id($ButtonValue);
} catch (DatabaseException $e) {

}

$ListeJeu = get_game_run_by_id($id, $params, $categorie, $idCategorie);
$rules = get_rules($id, $idCategorie);
?>

<body>
<div class="en_tete_jeu">
    <div class="contentImg">
        <img src='<?php echo htmlspecialchars($img); ?>' class="game_img" alt='<?php echo htmlspecialchars($nom); ?>'/>
        <h3 class="game_name"><?php echo htmlspecialchars($nom); ?></h3>
    </div>
</div>
<div class="category_page">
    <p data-category="run">Run</p>
    <p data-category="rules">Règle</p>
    <p data-category="guide">Guide</p>
    <p data-category="forum">Forum</p>
    <p data-category="statistique">Statistique</p>
</div>
<div class="Liste_run">
    <div class="Liste_categorie run-active">
    <span class="bouton_possibilite" onclick="document.querySelector('.toggle_categorie').click();">
        <input type="checkbox" class="toggle_categorie" style="display: none;">
        <span class="checkbox-text">Affichage des possibilité</span>
    </span>
        <div class="CategorieSelect">
            <?php foreach ($CategoryList as $category): ?>
                <button type="button" class="filter-btn"
                        data-filter="<?php echo htmlspecialchars($category['nom_categorie']); ?>" name="Button_value">
                    <?php echo htmlspecialchars($category['nom_categorie']); ?>
                </button>
            <?php endforeach; ?>
            <form method="post" action="" class="filtre_jeu">
                <label>
                    <select name="filter" id="filterSelect">
                        <option value='Joueur'> Joueur</option>
                        <option value='IGT'> IGT</option>
                        <option value='Date'> Date</option>
                        <option value='Plateforme'> Plateforme</option>
                        <option value='Version'> Version</option>
                    </select>
                </label>
                <label>
                    <input type="text" placeholder="<?php echo $placeholer ?>" id="filtre" name="filtre">
                </label>
                <label>
                    <input type="submit" value="Appliquer">
                </label>
                <div id="rulesPopup" class="popup hidden">
                    <div class="popup-content">
                        <span class="close-button" id="closePopup">&times;</span>
                        <h3 id="rulesTitle"></h3>
                        <p id="rulesText"></p>
                    </div>
                </div>
                <label>
                    <a href="get_game.php">
                        <input type="button" src="" value="Publier une run" class="submit_run_part">
                    </a>
                </label>
            </form>
        </div>
        <table>
            <thead>
            <tr>
                <th>Numéro</th>
                <th>Joueur</th>
                <th>IGT</th>
                <th>Date</th>
                <th>Plateforme</th>
                <th>Version</th>
            </tr>
            </thead>
            <tbody id="table_body">
            <?php
            $cpt = 1;
            foreach ($ListeJeu as $row): ?>
                <tr onclick="window.location.href='video_page.php?id_video=<?php echo htmlspecialchars($row['id']); ?>'">
                    <td><?php echo $cpt; ?></td>
                    <td><?php echo isset($row['Pseudo']) ? htmlspecialchars($row['Pseudo']) : 'N/A'; ?></td>
                    <td><?php echo isset($row['IGT']) ? htmlspecialchars(format_igt($row['IGT'], $_SESSION['unite_temps'])) : 'N/A'; ?></td>
                    <td><?php echo isset($row['date']) ? htmlspecialchars(format_date($row['date'], $_SESSION['format_date'])) : 'N/A'; ?></td>
                    <td><?php echo strtoupper(isset($row['Plateforme']) ? htmlspecialchars($row['Plateforme']) : 'N/A'); ?></td>
                    <td><?php echo isset($row['Version']) ? htmlspecialchars($row['Version']) : 'N/A'; ?></td>
                </tr>
                <?php $cpt++; ?>
            <?php endforeach; ?>
            </tbody>

        </table>

    </div>
    </div>
</body>

<script>
    const gameId = <?php echo json_encode($id); ?>;
    const gameRules = <?php echo json_encode($rules); ?>;
    document.querySelector('.toggle_categorie').addEventListener('change', function () {
        const filterCategorie = document.querySelector('.CategorieSelect');
        const texteFilter = document.querySelector('.checkbox-text');
        filterCategorie.style.display = this.checked ? 'block' : 'none';
        texteFilter.textContent = this.checked ? 'Masquer les possibilités' : 'Affichage des possibilité';
    });
</script>




<style>
    @media (min-width: 891px)
    {
    a {
        text-decoration: none;
        color: black;
    }
    .game_name {
        font-size: 1.5em;
        color: black;
    }
    .en_tete_jeu {
        background-color: #A2AEBB;
        color: white;
        padding: 20px;
        text-align: center;
    }

    .en_tete_jeu .contentImg {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .en_tete_jeu h3 {
        margin-top: 10px;
        font-size: 1.5em;
    }
    .category_page {
        display: flex;
        background-color: white;
        width: 800px;
    }

    .category_page p {
        padding: 10px;
    }

    .category_page p:hover {
        background-color: #007bff;
        color: white;
        border-radius: 5px;
    }

    .Liste_run {
        padding: 20px;
        background-color: #fff;
        margin: 20px auto;
        border-radius: 8px;
        max-width: 1200px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .Liste_run .Liste_categorie {
        margin-bottom: 20px;
    }

    .bouton_possibilite {
        display: flex;
        align-items: center;
        cursor: pointer;
        font-size: 1em;
        margin-bottom: 10px;
    }

    .CategorieSelect {
        flex-wrap: wrap;
        display: flex;
        gap: 10px;
        margin-bottom: 20px;

    }
    .CategorieSelect button {
        padding : 10px;
        background-color: white;
        color: black;
        border: none;
        border-radius: 4px;

    }
    .CategorieSelect button:hover {
        background-color: #007bff;
        color : white;
    }
    .CategorieSelect select ,
    .CategorieSelect input[type="text"],
    .CategorieSelect input[type="submit"],
    .CategorieSelect input[type="button"]

    {
        padding: 10px;
        margin: 10px 0 20px;
        font-size: 1em;
        border: 1px solid black;
        border-radius: 4px;
    }

    }
</style>
<?php
require_once "includes/footer.php";
?>