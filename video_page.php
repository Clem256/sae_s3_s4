<?php
require_once './includes/bdd_function.php';
require_once './includes/header.php';
require_once "includes/function.php";
$conn = get_bdd_connection();

$id_video = isset($_GET['id_video']) ? intval($_GET['id_video']) : null;
$pseudo = isset($_GET['Pseudo']) ? htmlspecialchars($_GET['Pseudo']) : null;

$sql = "SELECT * FROM liste_run JOIN jeu ON liste_run.game_id = jeu.id_jeu WHERE id = :id_video";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_video', $id_video, PDO::PARAM_INT);
$stmt->execute();
$video = $stmt->fetch();

if ($video) {
    $url = $video['video_link'];
    $video_id = null;
    if (preg_match('/youtu\.be\/([^\?]+)/', $url, $matches)) {
        $video_id = $matches[1];
    } else {
        $query_string = parse_url($url, PHP_URL_QUERY);
        if ($query_string) {
            parse_str($query_string, $query);
            $video_id = isset($query['v']) ? $query['v'] : null;
        }
    }

    if ($video_id) {
        $embed_url = "https://www.youtube.com/embed/" . htmlspecialchars($video_id);
    } else {
        $embed_url = null;
    }
    ?>
    <?php if (is_user_connected()): ?>
        <link rel="stylesheet" href="style/CSS/style.php?version=<?php echo time(); ?>">
    <?php else: ?>
        <link rel="stylesheet" href="style/CSS/style.css?v=1.0">
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <div class="video_info">
        <a href="game_page.php?id=<?= htmlspecialchars($video['id_jeu']); ?>&nom_jeu=<?= htmlspecialchars($video['nom_jeu']); ?>&image_url=<?= htmlspecialchars($video['lien_img']); ?>"><i
                    class="fas fa-arrow-left">Retour à la page de jeu </i></a>

        <p>Pseudo: <?php echo htmlspecialchars($video['Pseudo']); ?></p>
        <p>Jeu: <?php echo htmlspecialchars($video['nom_jeu']); ?></p>
        <p>Temps : <?php echo htmlspecialchars($video['IGT']); ?></p>
    </div>
    <?php if ($embed_url): ?>
        <iframe src="<?php echo $embed_url; ?>" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen class="ytp_video"></iframe>
    <?php else: ?>
        <p>Invalid video URL.</p>
    <?php endif; ?>
    <?php
} else {
    echo "<p>Video introuvable.</p>";
}
?>

<?php
require_once './includes/footer.php';
?>
