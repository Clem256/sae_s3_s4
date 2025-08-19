<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script src="Script/Chart.js"></script>
<script src="Script/GamePage_filtre.js"></script>
<script src="Script/Game_categorie.js"></script>
<script src="Script/LocalNotification.js"></script>
<script src="Script/Notification.js"></script>
<script src="Script/Rules_Popup.js"></script>
<script src="Script/stats_redirection.js"></script>
<script src='Script/PostsForums.js'></script>
<body>

<?php
require_once 'includes/bdd_function.php';
require_once 'includes/StatsFunction.php';
require_once 'includes/function.php';
?>
<?php if (is_user_connected()): ?>
    <link rel="stylesheet" href="style/CSS/style.php?version=<?php echo time(); ?>">
<?php else: ?>
    <link rel="stylesheet" href="style/CSS/style.css?v=1.0">
<?php endif; ?>
<?php
// Variables et initialisation
$id = intval($_GET['id'] ?? 0);
$CategoryList = get_game_categorie_by_id($id);
$defaultCategory = $_POST['categorie_jeu']
    ?? $CategoryList[0]['nom_categorie']
    ?? 'default_category_value';
$placeholder = 'Joueur...';
$params = '';
$categorie = '';
$idCategorie = '';
$placeholer = 'Joueur...';

if (isset($_GET['category'])) {
$category = $_GET['category'];

switch ($category) {
case 'run':
$categorie = $_POST['filter'] ?? $categorie;
$params = $_POST['filtre'] ?? $params;
$defaultCategory = $_POST['categorie_jeu'] ?? $defaultCategory;
$idCategorie = getCategorie_id($defaultCategory);

$ListeJeu = get_game_run_by_id($id, $params, $categorie, $idCategorie);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categorie = $_POST['filter'] ?? $categorie;
    $params = $_POST['filtre'] ?? $params;
    $defaultCategory = $_POST['categorie_jeu'] ?? $defaultCategory;
    $idCategorie = getCategorie_id($defaultCategory);
}


$ListeJeu = get_game_run_by_id($id, $params, $categorie, $idCategorie);

?>
<script>
    const data = <?= json_encode($ListeJeu) ?>;
</script>

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
            <label>
                <input type="button" id="rulesButton" value="Règles">
            </label>
            <div id="rulesPopup" class="popup hidden">
                <div class="popup-content">
                    <span class="close-button" id="closePopup">&times;</span>
                    <h3 id="rulesTitle"></h3>
                    <p id="rulesText"></p>
                </div>
            </div>
            <label>
                <a href="run.php">
                    <input type="button" src="" value="Publier une run">
                </a>
            </label>
        </form>
    </div>

    <?php if ($ListeJeu) : ?>
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
    <?php else : ?>
        <p class="no_run">Aucun run trouvé.</p>
    <?php endif; ?>
    <?php
    break;
    case 'rules' :
        $generalRules = get_general_rules($id);
        if (empty($generalRules)) {
            echo "<p>Aucune règle n'existe actuellement</p>";
        } else {
            foreach ($generalRules as $rule) {
                echo "<h4>" . htmlspecialchars($rule['Titre']) . "</h4><br>";
                echo "<p>" . htmlspecialchars($rule['Contenu']) . "</p><br>";
            }
        }
        $allRules = get_rules_games($id);
        if (empty($allRules)) {
            echo "<p>Aucune règle n'existe actuellement</p>";
        } else {
            foreach ($allRules as $rule) {
                echo "<h4> Règle pour la categorie :" . htmlspecialchars($rule['Titre']) . "</h4>";
                echo "<p>" . htmlspecialchars($rule['Contenu']) . "</p>";
            }
        }
        break;
    case 'guide':
        $GuideList = get_game_guides($id);
        ?>
        <h3>Guides disponibles</h3>
        <ul>
            <?php if (empty($GuideList)): ?>
                <li> Aucun guide n'existe actuellement</li>
            <?php else: ?>
                <?php foreach ($GuideList as $guide): ?>
                    <li><?= htmlspecialchars($guide['nom_guide']) ?> - <a
                                href="<?= htmlspecialchars($guide["lien_guide"]) ?>" target="_blank">lien</a>
                        <p><?= htmlspecialchars($guide["description"]) ?></p>
                    </li>

                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <?php
        break;

    case 'forum':

$forumPosts = get_forum_posts();
$commentairesPosts = get_posts_commentaires();

echo "<h3>Forum</h3>";

if (is_user_connected()) {
    echo "<button class='bouton_creation_post'>Créer un post</button>";
} else {
    echo "<p style='color: red;'>Connectez-vous pour créer un post ou ajouter des commentaires.</p>";
}

echo "<section class='posts_area'>";

foreach ($forumPosts as $post) {
    $user = get_user($post['id_utilisateur']) ?? 0;

    if ($_GET['id'] == $post['id_game'] && $user != 0) {
        $postCommentaires = array_values(array_map(function ($commentaire) {
            $utilisateur = get_user($commentaire['id_utilisateur']);
            $commentaire['nom_utilisateur'] = $utilisateur['nom_utilisateur'];
            return $commentaire;
        }, array_filter($commentairesPosts, function ($commentaire) use ($post) {
            return $commentaire['id_post'] == $post['id_post'];
        })));

        $id2 = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $dataAttributes = json_encode([
            'titre_post' => $post['titre_post'],
            'auteur_post' => $user['nom_utilisateur'],
            'contenu_post' => $post['contenu_post'],
            'id_post' => $post['id_post'],
            'commentaires' => $postCommentaires,
            'createur' => $user['id_utilisateur'] == $id2,
        ]);

        echo "<div class='forum_post' data-attributes='{$dataAttributes}'>";
        echo "<h3>{$post['titre_post']}</h3>";
        echo "<p>par : {$user['nom_utilisateur']}</p>";
        echo "</div>";
    }
}

echo "</section>";

echo "<section class='post_display'>";
echo "<button id='post_bouton_retour'>Retour</button>";
echo "<h1 id='titre_post'></h1>";
echo "<p id='auteur_post'></p>";
echo "<p id='contenu_post'></p>";

if (is_user_connected()) {
    echo "<form action='ajout_commentaire.php' method='POST' class='formulaire_commentaire'>";
    echo "<input type='hidden' id='id_post' name='id_post' value=''>";
    echo "<label for='commentaire'>Ajouter un commentaire:</label>";
    echo "<input type='text' id='commentaire' name='commentaire' required>";
    echo "<input type='submit' value='Envoyer'>";
    echo "</form>";
} else {
    echo "<p style='color: red;'>Connectez-vous pour ajouter un commentaire.</p>";
}

echo "<div class='commentaires_container'></div>";

if (is_user_connected()) {
    echo "<div class='boutons_alter'>";
    echo "<button class='post_bouton_mod'>Modifier ce post</button>";
    echo "<form action='supprimer_post.php' method='POST' class='supprimer'>";
    echo "<input type='hidden' id='id_post_suppr' name='id_post_suppr' value=''>";
    echo "<input class='post_bouton_suppr' type='submit' value='Supprimer ce post'>";
    echo "</form>";
    echo "</div>";
}
echo "</section>";

if (is_user_connected()) {
    echo "<section class='creation_post'>";
    echo "<form action='ajout_post.php' method='POST' class='formulaire_post'>";
    echo "<input type='hidden' id='id_jeu' name='id_jeu' value='{$_GET['id']}'>";
    echo "<label for='titre'>Titre de votre post:</label>";
    echo "<input type='text' id='titre' name='titre' maxlength='40' required>";
    echo "<label for='contenu'>Écrivez votre post:</label>";
    echo "<input type='text' id='contenu' name='contenu' required>";
    echo "<input type='submit' value='Envoyer'>";
    echo "</form>";
    echo "</section>";
}

echo "<section class='alter_post'>";
echo "<form action='alter_post.php' method='POST' class='formulaire_mod_post'>";
echo "<input type='hidden' id='id_post' name='id_post' value=''>";
echo "<label for='titre_mod'>Titre de votre post:</label>";
echo "<input type='text' id='titre_mod' name='titre_mod' maxlength='40' required>";
echo "<label for='contenu_mod'>Écrivez votre post:</label>";
echo "<input type='text' id='contenu_mod' name='contenu_mod' required>";
echo "<input type='submit' value='Envoyer'>";
echo "</form>";
echo "</section>";

break;


        case 'statistique':
        ?>
        <div class="stats_game_responsive">
            <h3>Statistique global</h3>
            <?php
            $nbPlayer = intval(get_player_number($id));
            $nbGame = intval(get_number_run($id));
            $Plateforme = get_plateforme($id);
            ?>
            <li>Nombre de joueurs: <?= $nbPlayer ?></li>
            <li>Nombre de runs: <?= $nbGame ?></li>
            <?php
            if (!empty($_POST['category_stats_select'])) {
                $categorie = $_POST['category_stats_select'] ?? '';
            } else {
                $categorie = $CategoryList[0]['nom_categorie'] ?? '';
            }
            ?>
            <h3>Statistiques de la categorie <?php echo $categorie ?></h3>
            <form method="post" action="" id="categoryStatsForm">
                <label>Choisissez la catégorie:
                    <select name="category_stats_select" id="categoryStatsSelect">
                        <?php foreach ($CategoryList as $category) : ?>
                            <option name="category_stats"
                                    value="<?= htmlspecialchars($category['nom_categorie']) ?>"><?= htmlspecialchars($category['nom_categorie']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <input type="submit" class="input_stats" value="Submit">
            </form>
            <?php
            $idCategorie = getCategorie_id($categorie) ?? '1';
            $nbPlayer = intval(get_player_number_by_category($id, $idCategorie));
            $nbGame = intval(get_number_run_by_category($id, $idCategorie));
            ?>
            <li>Nombre de joueurs: <?= $nbPlayer ?></li>
            <li>Nombre de runs: <?= $nbGame ?></li>
            <canvas id="PourcentagePlateforme" width="100" height="100"></canvas>
            <canvas id="TimeUpgrade" width="100" height="100"></canvas>
        </div>
        <?php
        break;

//    case 'notification':
//        $Notifications = "";
//        try {
//            $Notifications = get_user_notifications();
//        } catch (DatabaseException $e) {
//
//        }
//        ?>
<!--        <h3>Notifications</h3>-->
<!--        <ul>-->
<!--            --><?php //foreach ($Notifications as $notification) : ?>
<!--                <li>--><?php //= htmlspecialchars($notification['message'] ?? 'Aucune notification') ?><!--</li>-->
<!--            --><?php //endforeach; ?>
<!--        </ul>-->
<!--        <form action="" method="post">-->
<!--            <label>Choisissez le type de notification:</label>-->
<!--            <input type="radio" id="local_notif" name="notif_type" value="local_notif">-->
<!--            <label for="local_notif">Notification locale</label>-->
<!--            <input type="radio" id="mail_notif" name="notif_type" value="mail_notif">-->
<!--            <label for="mail_notif">Notification par mail</label> <br/>-->
<!---->
<!--            <label>Modification des règles:</label>-->
<!--            <input type="checkbox" id="notif_regle" name="notif_options[]" value="notif_regle"> <br/>-->
<!---->
<!--            <label>Ajout / modification des guides:</label>-->
<!--            <input type="checkbox" id="notif_guide" name="notif_options[]" value="notif_guide"> <br/>-->
<!---->
<!--            <input type="submit" id="sendNotification" value="Envoyer">-->
<!--        </form>-->
<!--        --><?php
//        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//            $notifType = $_POST['notif_type'] ?? '';
//            $notifOptions = $_POST['notif_options'] ?? [];
//            if ($notifType === 'local_notif') {
//                echo "Local notification selected.<br>";
//            } elseif ($notifType === 'mail_notif') {
//                echo "Mail notification selected.<br>";
//            }
//
//            if (in_array('notif_regle', $notifOptions)) {
//                echo "Notification for rule changes selected.<br>";
//            }
//            if (in_array('notif_guide', $notifOptions)) {
//                echo "Notification for guide changes selected.<br>";
//            }
//        }
//        ?>
<!--        --><?php
//        break;

    default:
        ?>
        <p>Catégorie inconnue.</p>
        <?php
        break;
    }
    }
    ?>
    <?php
    if (!empty($_POST['category_stats_select'])) {
        $categorie = $_POST['category_stats_select'] ?? '';
        $idCategorie = getCategorie_id($categorie) ?? '1';
    } else {
        $categorie = $CategoryList[0]['nom_categorie'] ?? '';
    }
    $labelsD = json_encode(array_column(get_plateforme_by_category($id, $idCategorie), 'plateforme') ?? array_column(get_plateforme($id), 'plateforme'));
    $dataD = json_encode(array_column(get_plateforme_by_category($id, $idCategorie), 'count') ?? array_column(get_plateforme($id), 'count'));
    $dates = json_encode(array_column(get_igt_and_time_by_category($id, $idCategorie), 'date') ?? array_column(get_igt_and_time($id), 'date'));
    $times = json_encode(array_column(get_igt_and_time_by_category($id, $idCategorie), 'IGT') ?? array_column(get_igt_and_time($id), 'IGT'));
    ?>
    <script>
        const defaultCategory = <?= json_encode($categorie) ?>;
        const labelsD = <?= $labelsD ?>;
        const dataD = <?= $dataD ?>;
        const dates = <?= $dates ?>;
        const times = <?= $times ?>;

        document.querySelector('.toggle_categorie').addEventListener('change', function () {
            const filterCategorie = document.querySelector('.CategorieSelect');
            const texteFilter = document.querySelector('.checkbox-text');
            filterCategorie.style.display = this.checked ? 'block' : 'none';
            texteFilter.textContent = this.checked ? 'Masquer les possibilités' : 'Affichage des possibilité';
        });
    </script>
</body>


<style>
    @media (min-width: 891px) {
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
        .no_run {
            text-align: center;
            font-size: 1.5em;
            color: black;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
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
        .stats_game_responsive li {
            list-style: none;
        }
        #categoryStatsSelect {
            padding: 5px;
            font-size: 1em;
            border: 1px solid black;
            border-radius: 4px;
            background-color: white;
            color: black;
            margin-bottom: 20px;
            margin-left: 10px;
            margin-right: 10px;
        }

        #categoryStatsSelect option {
            background-color: white;
            color: black;
            padding: 10px;
        }
        .input_stats {
            width: 100px;
            height: 35px;
            font-size: 1em;
            border: 1px solid black;
            border-radius: 4px;
            background-color: white;
            color: black;
            margin-bottom: 20px;
            margin-left: 10px;
            margin-right: 10px;
        }
    }
</style>
