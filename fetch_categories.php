<?php
require_once "includes/bdd_function.php";

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$jeuName = $input['jeuName'] ?? '';

if ($jeuName) {
    $idJeu = get_game_id($jeuName);
    if ($idJeu) {
        $categories = get_Categorie($idJeu);
        echo json_encode($categories);
    } else {
        echo json_encode(['error' => 'Jeu non trouvé.']);
    }
} else {
    echo json_encode(['error' => 'Nom du jeu manquant.']);
}
?>