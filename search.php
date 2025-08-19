<?php
require_once 'includes/bdd_function.php';
require_once 'includes/header.php';
require_once "includes/function.php";
$conn = get_bdd_connection();

$query = '';
$results = [];
$user_results = [];

if (isset($_GET['query'])) {
    $query = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
    if ($query) {
        // Vérifier si le query correspond à un nom_utilisateur
        $user_sql = "SELECT id_utilisateur, nom_utilisateur, avatar_url FROM utilisateur JOIN params ON
        utilisateur.id_utilisateur = params.id_joueur WHERE nom_utilisateur LIKE ? AND params.visibilite_profil != 1";
        $user_stmt = $conn->prepare($user_sql);
        $user_stmt->execute(['%' . $query . '%']);
        $user_results = $user_stmt->fetchAll(PDO::FETCH_ASSOC);
        // Rechercher les jeux correspondant au query
        $sql = "SELECT id_jeu, nom_jeu, lien_img FROM jeu WHERE nom_jeu LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['%' . $query . '%']);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
<?php if (is_user_connected()): ?>
    <link rel="stylesheet" href="style/CSS/style.php?version=<?php echo time(); ?>">
<?php else: ?>
    <link rel="stylesheet" href="style/CSS/style.css?v=1.0">
<?php endif; ?>
<?php if ($query): ?>
    <h1 class="search-title">Résultat pour : <?= htmlspecialchars($query) ?></h1>
<div class="resultat_recherche">

    <div class="filter-buttons">
        <button id="btn-tous">Tous</button>
        <button id="btn-jeux">Jeux</button>
        <button id="btn-utilisateurs">Utilisateurs</button>
    </div>
    <div class="search-result">
        <div id="results">
            <?php if ($user_results): ?>
                <div id="user-results">
                    <h2>Utilisateurs trouvés :</h2>
                    <ul>
                        <?php foreach ($user_results as $user): ?>
                            <li>
                                <?php $pseudo = $user['nom_utilisateur'] ?>
                                <a href="Profil.php?nom_utilisateur=<?= urlencode($user['nom_utilisateur']) ?>">
                                    <?= htmlspecialchars($user['nom_utilisateur']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if ($results): ?>
            <div id="game-results">
                <h2>Jeux trouvés :</h2>
                <ul>
                    <?php foreach ($results as $result): ?>
                        <li>
                            <a href="game_page.php?id=<?= $result['id_jeu'] ?>&nom_jeu=<?= urlencode($result['nom_jeu']) ?>&image_url=<?= urlencode($result['lien_img']) ?>">
                                <?= htmlspecialchars($result['nom_jeu']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php else: ?>
            <?php if (!$user_results): ?>
                <?php
                header('Location: NotFound.php?query=' . urlencode($query));
                exit();
                ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php else: ?>
        <p>Pas de query</p>
    <?php endif; ?>
</div>
<script src="Script/search_bar_filter.js"></script>
<?php
require_once 'includes/footer.php';
?>
<style>
    body {
        text-align: center;
    }
    .resultat_recherche {
        max-width: 1000px;
        margin: 20px auto;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .filter-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .filter-buttons button {
        background-color: white;
        border: 1px solid black;
        padding: 10px 20px;
        border-radius: 5px;
    }

    .filter-buttons button:hover {
        background-color: cornflowerblue;
    }

    /* Résultats de la recherche */
    .search-result {
        flex: 1;
        margin-left: 20px;
    }

    .search-result ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .search-result li {
        text-align: left;
        margin: 10px 0;
        padding: 10px;
        border-radius: 5px;
    }

    .search-result li:hover {
        background-color: white;
    }

    .search-result li a {
        text-decoration: none;
        font-weight: bold;
    }

    .search-result li a:hover {
        text-decoration: underline;
    }

    #user-results h2,
    #game-results h2 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .resultat_recherche {
            flex-direction: column;
        }

        .filter-buttons {
            flex: 1;
            flex-direction: row;
            justify-content: space-around;
            margin-bottom: 20px;
        }


    }

    @media (max-width: 480px) {
        .search-title {
            font-size: 18px;
        }

        .filter-buttons button {
            font-size: 14px;
            padding: 8px 10px;
        }

        .search-result li {
            padding: 8px;
            font-size: 12px;
        }
    }

    footer {
        max-width: 100%;
        margin-top: auto;
    }
</style>
