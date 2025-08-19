<?php
require_once 'includes/header.php';
require_once 'includes/function.php';

?>
<?php if (is_user_connected()): ?>
    <link rel="stylesheet" href="style/CSS/style.php?version=<?php echo time(); ?>">
<?php else: ?>
    <link rel="stylesheet" href="style/CSS/style.css?v=1.0">
<?php endif; ?>
<body>
<div class="jeu">
    <?php
    require_once 'includes/accueil.php';
    ?>
</div>
</body>
<?php
require_once 'includes/footer.php';
?>

