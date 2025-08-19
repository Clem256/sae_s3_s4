<?php require_once "../includes/function.php"; ?>
<?php if (is_user_connected()): ?>
    <link rel="stylesheet" href="../style/CSS/style.php?version=<?php echo time(); ?>">
<?php else: ?>
    <link rel="stylesheet" href="../style/CSS/style.css?v=1.0">
<?php endif; ?>

<footer>
    <h3><a href="legal_mention.php">Mentions légales</a></h3>
    <h3><a href="condition_utilisation.php">Conditions d'utilisation</a></h3>
    <h3>Plan du site</h3>
    <h3><a href="Contact.php">Contacts</a></h3>
    <h3>Localisation</h3>
    <h3><a href="Copyright.php">Copyright</a></h3>
    <h5>Ce site web est développé dans le cadre d'un projet universitaire, et donc ce site n'a aucune intention de
        remplacer les sites déjà existants sur ce sujet.</h5>
</footer>
