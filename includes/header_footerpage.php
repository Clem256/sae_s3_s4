<?php
require_once "function.php";
$avatar_url = null;

if (is_user_connected()) {
    $pseudo = $_SESSION['pseudo'];
    $avatar_url = $_SESSION['avatar_url'];
}
$player = $_SESSION['pseudo'] ?? "";
?>
<script src="../Script/Notification.js"></script>
<head>
    <base href="./code">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le meilleur site Speedrun 2024</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css'>
    <?php if (is_user_connected()): ?>
        <link rel="stylesheet" href="../style/CSS/style.php?version=<?php echo time(); ?>">
    <?php else: ?>
        <link rel="stylesheet" href="../style/CSS/style.css?v=1.0">
    <?php endif; ?>
</head>


<body id="body">
<div class="navheader">
    <div class="left">
        <a href="../index.php">
            <img src="../style/IMG/logo.png" class="logo_site">
        </a>
        <h1 id="website_title">Speedrun zikette</h1>
    </div>
    <div class="left">
        <form method="get" action="search.php">
            <input type="text" name="query" id="barrerecherche" class="barrerecherche" placeholder="Recherche...">
        </form>
    </div>
    <div class="right">
        <label for="menu-cb" class="menu-label">
            <i class="fas fa-ellipsis-v"></i>
        </label>
        <input type="checkbox" id="menu-cb" class="menu-cb">
        <nav class="menu-nav">
            <ul>
                <div class="display_info">
                    <?php if (is_user_connected()) : ?>
                        <li class="menu-item"><a href="Profil.php?nom_utilisateur=<?= $player ?>">Profil</a></li>
                    <?php else: ?>
                        <li class="menu-item"><a href="pdo.php">Profil</a></li>
                    <?php endif; ?>
                    <li class="menu-item"><a href="#">Messages</a></li>
                </div>
                <li class="menu-item"><a href="run.php">Soumettre une run</a></li>
                <li class="menu-item"><a href="propositions_users.php">Soumettre une catégorie</a></li>
            </ul>
        </nav>
        <nav class="categorie_header">
            <!--            <i class="fas fa-heart"></i>-->
            <!--            <i class="fas fa-comment"></i>-->
            <i class="fas fa-bell"></i>
            <a href="../code/pdo.php">
                <?php if ($avatar_url): ?>
                    <img src="<?php echo htmlspecialchars($avatar_url); ?>" alt="Avatar" class="user-avatar">
                <?php else: ?>
                    <img src="../style/IMG/base_profile_b" alt="Avatar" class="user-avatar">
                <?php endif; ?>
            </a>
            <!--            <i class="fas fa-globe"></i>-->
            <!--            <i class="fas fa-moon" id="changeDarkLight"></i>-->
        </nav>
    </div>
</div>
<script src="../Script/DarkLightMode.js"></script>
<script src="../Script/menu.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('menu-cb');
        input.addEventListener('click', changerEtatMenu);
    });
</script>
</body>