<?php require_once "../includes/function.php"; ?>
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
            <img src="../style/IMG/logo.png">
        </a>
        <h1 id="test">Speedrun ziquette</h1>
    </div>
    <div class="left">
        <form method="get" action="../search.php">
            <input type="text" name="query" id="barrerecherche" placeholder="Recherche...">
        </form>
    </div>
    <div class="right">
        <label for="menu-cb" class="menu-label">
            <i class="fas fa-ellipsis-v"></i>
        </label>
        <input type="checkbox" id="menu-cb" class="menu-cb">
        <nav class="menu-nav">
            <ul>
                <li class="menu-item"><a href="run.php">Soumettre une run</a></li>
                <li class="menu-item"><a href="propositions_users.php">Soumettre une catégorie</a></li>
            </ul>
        </nav>
        <i class="fas fa-heart"></i>
        <i class="fas fa-comment"></i>
        <i class="fas fa-bell"></i>
        <a href="../pdo.php"><i class="fas fa-user-circle"></i></a>
        <i class="fas fa-globe"></i>
        <i class="fas fa-moon" id="changeDarkLight"></i>
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