<?php
require_once "includes/bdd_function.php";
require_once "includes/StatsFunction.php";
$category = $_GET['category'] ?? $_POST['category'] ?? '';
$id = $_GET['id'] ?? $_POST['id'] ?? '';
if (empty($id)) {
    echo json_encode(['error' => 'ID utilisateur manquant']);
    exit;
}
$joueur = $_SESSION['pseudo'] ?? "";
$ListOk = get_validate_run_by_user($id);
$ListPending = get_waiting_run_by_user($id);
$player = get_user($id);

if ($player === false || empty($player['nom_utilisateur'])) {
    echo json_encode(['error' => 'User not found']);
    exit;
}

$paramsUser = "";
$ListUserTheme = "";
$userInformation = "";

$nbRun = get_player_number_run($player['nom_utilisateur']);
$nbGame = get_player_number_game($player['nom_utilisateur']);
$PlayerGame = get_player_game_list($player['nom_utilisateur']);
$PlayerCategory = get_player_category($player['nom_utilisateur']);
$firstRunDate = get_first_run_date($player['nom_utilisateur']);
$lastRunDate = get_last_run_date($player['nom_utilisateur']);

try {
    $paramsUser = get_params_by_player($id);
} catch (DatabaseException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
try {
    $ListUserTheme = get_all_theme_by_user($id);
} catch (DatabaseException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
try {
    $userInformation = get_user($id);
} catch (DatabaseException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
require_once 'includes/function.php';

?>

<?php if (is_user_connected()): ?>
    <link rel="stylesheet" href="style/CSS/style.php?version=<?php echo time(); ?>">
<?php else: ?>
    <link rel="stylesheet" href="style/CSS/style.css?v=1.0">
<?php endif; ?>
<?php
switch ($category) {
    case 'verified_run':
        ?>
        <?php if ($ListOk) : ?>
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
            <tbody>
            <?php
            $cpt = 1;
            foreach ($ListOk as $row) {
                ?>
                <tr onclick="window.location.href='video_page.php?id_video=<?php echo htmlspecialchars($row['id']); ?>'">
                    <td><?php echo $cpt; ?></td>
                    <td><?php echo isset($row['Pseudo']) ? htmlspecialchars($row['Pseudo']) : 'N/A'; ?></td>
                    <td><?php echo isset($row['IGT']) ? htmlspecialchars(format_igt($row['IGT'], $_SESSION['unite_temps'])) : 'N/A'; ?></td>
                    <td><?php echo isset($row['date']) ? htmlspecialchars(format_date($row['date'], $_SESSION['format_date'])) : 'N/A'; ?></td>
                    <td><?php echo strtoupper(htmlspecialchars($row['Plateforme'])); ?></td>
                    <td><?php echo htmlspecialchars($row['Version']); ?></td>
                </tr>
                <?php
                $cpt++;
            }
            ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune run vérifiée trouvée.</p>
    <?php endif; ?>
    <?php
        break;
    case 'pending_run':
        ?>
        <?php if ($ListPending) : ?>
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
            <tbody>
            <?php
            $cpt = 1;
            foreach ($ListPending as $row) {
                ?>
                <tr onclick="window.location.href='video_page.php?id_video=<?php echo htmlspecialchars($row['id']); ?>'">
                    <td><?php echo $cpt; ?></td>
                    <td><?php echo isset($row['Pseudo']) ? htmlspecialchars($row['Pseudo']) : 'N/A'; ?></td>
                    <td><?php echo isset($row['IGT']) ? htmlspecialchars(format_igt($row['IGT'], $_SESSION['unite_temps'])) : 'N/A'; ?></td>
                    <td><?php echo isset($row['date']) ? htmlspecialchars(format_date($row['date'], $_SESSION['format_date'])) : 'N/A'; ?></td>
                    <td><?php echo strtoupper(htmlspecialchars($row['Plateforme'])); ?></td>
                    <td><?php echo htmlspecialchars($row['Version']); ?></td>
                </tr>
                <?php
                $cpt++;
            }
            ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune run vérifiée trouvée.</p>
    <?php endif; ?>
    <?php
        break;
    case 'stats':
        ?>
        <div class="profile_stats">
            <div class="stats_profil">
                <h3>Nombre de course : <?php echo $nbRun ?></h3>
            </div>
            <div class="stats_profil">
                <h3>Nombre de jeu : <?php echo $nbGame?></h3>
            </div>
            <div class="stats_profil">
                <div class="game-list-container">
                    <h3>Liste des jeux</h3>
                    <label>
                        <?php if (is_array($PlayerGame) && !empty($PlayerGame)) : ?>
                            <select>
                                <?php foreach ($PlayerGame as $game) : ?>
                                    <option><?php echo htmlspecialchars($game['nom_jeu']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php else : ?>
                            <p>N/A</p>
                        <?php endif; ?>
                    </label>
                </div>
            </div>
            <div class="stats_profil">
                <div class="game-list-container">

                <h3>Nombre de catégories essayé</h3>
                <label>
                    <?php if (is_array($PlayerCategory) && !empty($PlayerCategory)) : ?>
                        <select>
                            <?php foreach ($PlayerCategory as $cate) : ?>
                                <option><?php echo htmlspecialchars($cate['nom_categorie'] . '(' . $cate['nom_jeu'] . ')'); ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php else : ?>
                        <p>N/A</p>
                    <?php endif; ?>
                </label>
                </div>
            </div>
            <div class="stats_profil">
                <h3>Date première course: <?php echo htmlspecialchars($firstRunDate ?? 'N/A'); ?></h3>
            </div>
            <div class="stats_profil">
                <h3>Date dernière course: <?php echo htmlspecialchars($lastRunDate ?? 'N/A'); ?></h3></div>
        </div>

        <?php
        break;
    case 'comments':
        echo "<h2>Commentaires</h2><p>Vos derniers commentaires apparaîtront ici.</p>";
        break;
    default:
        break;
}
?>
<style>
    .stats_profil select {
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 10px;
        font-size: 1em;
        color: #333;
        width: 100%;

    }

    .stats_profil select:hover {
        background-color: #e0e0e0;
    }

    .stats_profil select:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); 
    }
</style>
