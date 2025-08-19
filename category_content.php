<header>
    <script src="Script/Game_categorie.js"></script>
</header>
<?php
require_once 'includes/bdd_function.php';

if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $id = intval($_GET['id']);

    echo "Test";
}

?>

