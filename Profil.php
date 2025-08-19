<?php require_once "includes/header.php";
require_once "includes/bdd_function.php";
require_once "includes/function.php";
$player = $_GET['nom_utilisateur'] ?? '';
try {
    $id = get_user_id($player);
} catch (DatabaseException $e) {

}
try {
    $user = get_user($id);
} catch (DatabaseException $e) {

}
try {
    $ListOk = get_validate_run_by_user($id);
} catch (DatabaseException $e) {

}
try {
    $GetBioPronom = get_params_by_player($id);
} catch (DatabaseException $e) {

}
?>
<script>
    const id_user = <?php echo json_encode($id); ?>;
</script>
<script src="Script/Profil_sous_page.js"></script>
<?php if (is_user_connected()): ?>
    <link rel="stylesheet" href="style/CSS/style.php?version=<?php echo time(); ?>">
<?php else: ?>
    <link rel="stylesheet" href="style/CSS/style.css?v=1.0">
<?php endif; ?>
<div class="user">
    <?php if (!empty($user['avatar_url'])): ?>
        <img src="<?php echo $user['avatar_url'] ?>" alt="avatar" id="avatar" class="avatar_usr">
    <?php else: ?>
        <img src="./style/IMG/base_profile_b.png" alt="avatar" id="avatar">
    <?php endif; ?>
    <?php if ($user): ?>
        <h1><?php echo $user['nom_utilisateur'] ?></h1>
    <?php else: ?>
        <h1>User not found</h1>
    <?php endif; ?>

</div>

<?php
//if (isset($_POST['deconnexion'])) {
//    session_destroy();
//    header('Location: index.php');
//}
//?>
<div class="user_sous_page">
    <p data-category="verified_run">Run vérifiée</p>
    <p data-category="pending_run">Run en attente</p>
    <p data-category="stats">Stats</p>
    <?php if (isset($_SESSION['pseudo']) && ($_SESSION['pseudo'] == $player) && is_user_connected()) : ?>
        <p data-category="settings"><a href="params.php?id=<?php echo urlencode($id); ?>">Paramètre</a></p>
    <?php endif; ?>
    <?php if (isset($_SESSION['pseudo']) && ($_SESSION['pseudo'] == $player) && is_user_connected() && $user['admin'] == 1) : ?>
        <p data-category="admin"><a href="admin/index.php">Admin</a></p>
    <?php endif; ?>
</div>

<div class="content">
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
</div>

<?php require_once "includes/footer.php"; ?>

<style>
    @media (min-width: 891px) {
        #avatar {
            border-radius: 50%;
        }
        .user {
            display: flex;
            align-items: center;
            gap: 20px;
            background-color: #A2AEBB;
            padding: 20px;
            max-width: 800px;
            border-radius: 10px;
            height: 150px;
        }

        .user img#avatar {
            border-radius: 50%;
            width: 100px;
            height: 100px;
        }
        .user h1 {
            font-size: 1.8rem;
            font-weight: bold;
            margin: 0;
            color: black;
        }
        .user_sous_page {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: white;
            padding: 15px;
            border-radius: 10px;
        }

        .user_sous_page p {
            font-size: 1rem;
            font-weight: bold;
            color: #555;
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .user_sous_page p:hover {
            background-color: #007bff;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 1rem;
            background-color: #fff;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 1000px;
        }
        footer {
            width: 100%;
            max-width: 100%;
            background-color: #f1f1f1;
            text-align: center;
            position: relative;
            bottom: 0;
            left: 0;
        }
    }
</style>