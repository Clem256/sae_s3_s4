<?php
require_once 'includes/header.php';
require_once 'includes/function.php';
$query = isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '';
?>
<?php if (is_user_connected()): ?>
    <link rel="stylesheet" href="style/CSS/style.php?version=<?php echo time(); ?>">
<?php else: ?>
    <link rel="stylesheet" href="style/CSS/style.css?v=1.0">
<?php endif; ?>
    <title>404 Not Found</title>

    <h1>Erreur , aucune ressouce ne correspond à <?php echo $query ?></h1>
    <img src="style/IMG/error404.jpg" alt="image error 404" class="error_404">
<?php

require_once 'includes/footer.php';
?>