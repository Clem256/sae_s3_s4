<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
</head>
<?php
require_once 'bdd_function.php';

// function pour les graphiques de games page
function get_player_number($id_game)
{
    $conn = get_bdd_connection();
    $stmt = $conn->prepare("SELECT COUNT(DISTINCT Pseudo) AS player_number FROM liste_run WHERE game_id = :id_game");
    $stmt->bindParam(':id_game', $id_game, PDO::PARAM_INT);
    $stmt->execute();
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultat['player_number'];
}

function get_number_run($id_game)
{
    $conn = get_bdd_connection();
    $stmt = $conn->prepare("SELECT COUNT(DISTINCT IGT) AS nb_game FROM liste_run WHERE game_id = :id_game");
    $stmt->bindParam(':id_game', $id_game, PDO::PARAM_INT);
    $stmt->execute();
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultat['nb_game'];
}

function get_player_number_by_category($id_game, $category)
{
    $conn = get_bdd_connection();
    $stmt = $conn->prepare("SELECT COUNT(DISTINCT Pseudo) AS player_number FROM liste_run WHERE game_id = :id_game AND id_categorie = :category");
    $stmt->bindParam(':id_game', $id_game, PDO::PARAM_INT);
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    $stmt->execute();
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultat['player_number'];
}

function get_number_run_by_category($id_game, $category)
{
    $conn = get_bdd_connection();
    $stmt = $conn->prepare("SELECT COUNT( IGT) AS nb_game FROM liste_run WHERE game_id = :id_game AND id_categorie = :category");
    $stmt->bindParam(':id_game', $id_game, PDO::PARAM_INT);
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    $stmt->execute();
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultat['nb_game'];
}


function get_plateforme($id_game)
{
    $conn = get_bdd_connection();
    $stmt = $conn->prepare("SELECT Plateforme AS plateforme, COUNT(*) AS count FROM liste_run WHERE game_id = :id_game GROUP BY Plateforme");
    $stmt->bindParam(':id_game', $id_game, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_igt_and_time($id_game)
{
    $conn = get_bdd_connection();
    $stmt = $conn->prepare("
        SELECT 
            DATE_FORMAT(date, '%Y-%m-%d') AS date, 
            IGT 
        FROM liste_run 
        WHERE game_id = :id_game AND IGT IS NOT NULL
        ORDER BY date ASC
    ");
    $stmt->bindParam(':id_game', $id_game, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;


}

function get_plateforme_by_category($id, $category)
{
    $conn = get_bdd_connection();
    $stmt = $conn->prepare("SELECT Plateforme AS plateforme, COUNT(*) AS count FROM liste_run WHERE game_id = :id_game AND id_categorie = :category GROUP BY Plateforme");
    $stmt->bindParam(':id_game', $id, PDO::PARAM_INT);
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function get_igt_and_time_by_category($id, $category)
{
    $conn = get_bdd_connection();
    $stmt = $conn->prepare("
        SELECT 
            DATE_FORMAT(date, '%Y-%m-%d') AS date, 
            IGT 
        FROM liste_run 
        WHERE game_id = :id_game AND IGT IS NOT NULL AND id_categorie = :category
        ORDER BY IGT DESC
    ");
    $stmt->bindParam(':id_game', $id, PDO::PARAM_INT);
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}


//function pour les profil

/**
 * @throws DatabaseException
 */
function get_player_number_run($player)
{
    $conn = get_bdd_connection();
    $stmt = $conn->prepare("SELECT COUNT(DISTINCT IGT) as nb_game FROM liste_run WHERE Pseudo = :player");
    $stmt->bindParam(':player', $player, PDO::PARAM_STR);
    $stmt->execute();
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultat['nb_game'];
}

function get_player_number_game($player)
{
    $conn = get_bdd_connection();
    $stmt = $conn->prepare("SELECT COUNT(DISTINCT game_id) as nb_game FROM liste_run WHERE Pseudo = :player");
    $stmt->bindParam(':player', $player, PDO::PARAM_STR);
    $stmt->execute();
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultat['nb_game'];
}

function get_first_run_date($player)
{
    $conn = get_bdd_connection();
    $stmt = $conn->prepare("SELECT MIN(date) as first_run_date FROM liste_run WHERE Pseudo = :player");
    $stmt->bindParam(':player', $player, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['first_run_date'];
}

function get_last_run_date($player)
{
    $conn = get_bdd_connection();
    $stmt = $conn->prepare("SELECT MAX(date) as last_run_date FROM liste_run WHERE Pseudo = :player");
    $stmt->bindParam(':player', $player, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['last_run_date'];
}

/**
 * @throws DatabaseException
 */
function get_player_game_list($player): array
{
    $conn = get_bdd_connection();
    $stmt = $conn->prepare("SELECT DISTINCT j.nom_jeu FROM liste_run l JOIN jeu j on l.game_id = j.id_jeu WHERE Pseudo = :player");
    $stmt->bindParam(':player', $player, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_player_category($player)
{
    $conn = get_bdd_connection();
    $stmt = $conn->prepare("SELECT DISTINCT c.nom_categorie, j.nom_jeu FROM liste_run l 
                            JOIN categorie c ON l.id_categorie = c.id 
                            JOIN jeu j ON l.game_id = j.id_jeu 
                            WHERE l.Pseudo = :player");
    $stmt->bindParam(':player', $player, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
