<?php
require_once "bdd_function.php";
require_once 'Classe/game.php';
require_once 'function.php';
try {
    $conn = get_bdd_connection();
} catch (DatabaseException|Exception $e) {

}
// Récupération des plateformes
$plateformes = get_plateforme_filter();
$listeImage = "";
$filtre_sort = isset($_POST['filtre_sort']) ? $_POST['filtre_sort'] : '0';
$filtre_plateforme = isset($_POST['filtre_plateforme']) ? $_POST['filtre_plateforme'] : '0';
switch ($filtre_sort) {
    case '1':
        $ListeImage = get_game_sorted_by('most_played');
        break;
    case '2':
        $ListeImage = get_game_sorted_by('least_played');
        break;
    case '3':
        $ListeImage = get_game_sorted_by('recent_runs');
        break;
    default:
        $ListeImage = get_game();
        break;
}
if ($filtre_plateforme != '0') {
    switch ($filtre_plateforme) {

        case '1':
            $ListeImage = get_game_by_platform('PC');
            break;
        case '2':
            $ListeImage = get_game_by_platform('PS4');
            break;
        case '3':
            $ListeImage = get_game_by_platform('XBOX');
            break;
        default:
            $ListeImage = get_game();
            break;
    }
}
$members = get_all_members();
?>
<?php if (is_user_connected()): ?>
    <link rel="stylesheet" href="../style/CSS/style.php?version=<?php echo time(); ?>">
<?php else: ?>
    <link rel="stylesheet" href="../style/CSS/style.css?v=1.0">
<?php endif; ?>
<title>Accueil</title>
<body>

<div class="filtre">
    <form id="filterForm" method="post" action="./index.php">
        <div class="header-options">
            <span class="bouton_accueil">
                <input type="checkbox" id="toggleCheckbox" style="display: none;">
                <label for="toggleCheckbox" class="checkbox-text">Affichage des possibilités</label>
            </span>
            <div id="filterCategorie" class="filter-grid">
                <div class="platform">
                    <h3>Plateforme</h3>
                    <label>
                        <select id="Filtre_Plateforme" name="filtre_plateforme">
                            <option value="0">--Choisir un filtre--</option>
                            <option value="1" <?= $filtre_plateforme == '1' ? 'selected' : '' ?>>Pc</option>
                            <option value="2" <?= $filtre_plateforme == '2' ? 'selected' : '' ?>>PS4</option>
                            <option value="3" <?= $filtre_plateforme == '3' ? 'selected' : '' ?>>XBOX</option>
                        </select>
                    </label>
                </div>
                <div class="platform">
                    <h3>Filtre</h3>
                    <select class="filtre_divers" name="filtre_sort">
                        <option value="0">--Choisir un filtre--</option>
                        <option value="1" <?= $filtre_sort == '1' ? 'selected' : '' ?>>Trier par le plus joué</option>
                        <option value="2" <?= $filtre_sort == '2' ? 'selected' : '' ?>>Trier par le moins joué</option>
                        <option value="3" <?= $filtre_sort == '3' ? 'selected' : '' ?>>Trier par les runs les plus récents</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>


<div class="Imgjeu">
    <div class="Imgjeu">
        <?php foreach ($ListeImage as $image): ?>
            <?php
            $id = $image['id_jeu'];
            $nom = $image['nom_jeu'];
            $image_url = $image['lien_img'];
            ?>
            <a href="game_page.php?id=<?= $id ?>&nom_jeu=<?= htmlspecialchars($nom) ?>&image_url=<?= urlencode($image_url) ?>">
                <img src="<?= htmlspecialchars($image_url) ?>" alt="<?= htmlspecialchars($nom) ?>"
                     class="image-jeu">
            </a>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
<?php
require_once "footer.php";
?>
<script>
    // style pour le filtre en responsive
    const toggleCheckbox = document.getElementById('toggleCheckbox');
    const filterCategorie = document.getElementById('filterCategorie');
    const checkboxText = document.querySelector('.checkbox-text');

    toggleCheckbox.addEventListener('change', function () {
        const isChecked = toggleCheckbox.checked;
        filterCategorie.style.display = isChecked ? 'block' : 'none';
        checkboxText.textContent = isChecked ? 'Masquer les possibilités' : 'Affichage des possibilités';
    });
    // filtre pour envoyer automatiquent le forumlaire des select
    document.getElementById('Filtre_Plateforme').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });

    document.querySelector('.filtre_divers').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
</script>
