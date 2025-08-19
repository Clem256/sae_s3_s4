<?php
require_once "includes/header.php";
require_once "includes/bdd_function.php";
require_once "includes/function.php";
$id = $_GET['id'] ?? '';
$player = get_user($id);
//var_dump($player);
$paramsUser = "";
$ListUserTheme = "";
$userInformation = "";
if (isset($_POST['deconnexion'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}
try {
    $paramsUser = get_params_by_player($id);
} catch (DatabaseException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
try {
    $ListUserTheme = get_all_theme_by_user($id);
} catch (DatabaseException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
try {
    $userInformation = get_user($id);
} catch (DatabaseException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
$unique_name = "";
?>
<?php if (is_user_connected()): ?>
    <link rel="stylesheet" href="style/CSS/style.php?version=<?php echo time(); ?>">
<?php else: ?>
    <link rel="stylesheet" href="style/CSS/style.css?v=1.0">
<?php endif; ?>
<?php if(is_user_connected() and $_SESSION['pseudo'] == $player['nom_utilisateur']): ?>
<!--    <div class="data-category">Profil</div>-->
<!--    <div class="data-category">Compte</div>-->
<!--    <div class="data-category">Apparence</div>-->
<!--    <div class="data-category">Confidentialité</div>-->
    <div class="settings">


        <form action="" method="post" enctype="multipart/form-data">
            <h2 class="settings-title">Thème</h2>
            <label>
                Affecter un nom au thème :
                <input type="text" placeholder="Nom thème" name="nom_theme">
            </label>
            <label> Couleur du nom
                <select name="name_color">
                    <option value="white">Blanc</option>
                    <option value="red">Rouge</option>
                    <option value="blue">Bleu</option>
                    <option value="green">Vert</option>
                    <option value="yellow">Jaune</option>
                    <option value="orange">Orange</option>
                    <option value="purple">Violet</option>
                    <option value="pink">Rose</option>
                    <option value="brown">Marron</option>
                    <option value="gray">Gris</option>
                </select>
            </label>
            <label> Couleur de fond
                <select name="background_color">
                    <option value="white">Blanc</option>
                    <option value="red">Rouge</option>
                    <option value="blue">Bleu</option>
                    <option value="green">Vert</option>
                    <option value="yellow">Jaune</option>
                    <option value="orange">Orange</option>
                    <option value="purple">Violet</option>
                    <option value="pink">Rose</option>
                    <option value="brown">Marron</option>
                    <option value="gray">Gris</option>
                </select>
            </label>
            <label> Couleur de texte
                <select name="text_color">
                    <option value="white">Blanc</option>
                    <option value="red">Rouge</option>
                    <option value="blue">Bleu</option>
                    <option value="green">Vert</option>
                    <option value="yellow">Jaune</option>
                    <option value="orange">Orange</option>
                    <option value="purple">Violet</option>
                    <option value="pink">Rose</option>
                    <option value="brown">Marron</option>
                    <option value="gray">Gris</option>
                </select>
            </label>
<!--            <label> Image de fond :-->
<!--                <input type="file" name="avatar_input">-->
<!--            </label>-->
            <button type="submit" name="add_theme">Ajouter un thème</button>
        </form>
        <?php
        if (isset($_POST['add_theme'])) {
            $nom_theme = $_POST['nom_theme'] ?? '';
            $name_color = $_POST['name_color'] ?? '';
            $background_color = $_POST['background_color'] ?? '';
            $text_color = $_POST['text_color'] ?? '';
            $avatar_input = $_FILES['avatar_input']['name'] ?? '';

            if ($nom_theme && $name_color && $background_color && $text_color) {
                $upload_dir = 'uploads/';
                $upload_file = '';

                if (!empty($avatar_input)) {
                    $unique_name = uniqid('img_', true) . '.' . pathinfo($_FILES['avatar_input']['name'], PATHINFO_EXTENSION);
                    $upload_file = $upload_dir . $unique_name;

                    if (move_uploaded_file($_FILES['avatar_input']['tmp_name'], $upload_file)) {
                        echo "Fichier uploadé avec succès.";
                    } else {
                        echo "Échec de l'upload.";
                        exit;
                    }
                }
                try {
                    add_theme_by_user($id, $nom_theme, $name_color, $background_color, $text_color, $upload_file);
                    echo "<p>Thème enregistré avec succès.</p>";
                } catch (Exception $e) {
                    echo "Erreur : " . $e->getMessage();
                }
            } else {
                echo "<p>Veuillez remplir tous les champs.</p>";
            }
        }
        ?>


        <h2 class="settings-title">Compte</h2>
        <h4> Nom d'utilisateur : <?php echo $userInformation['nom_utilisateur']; ?></h4>
        <h4> Adresse mail : <?php echo $userInformation['email']; ?></h4>

        <h3 class="settings-title"> Changement </h3>
        <form method="post" action="" enctype="multipart/form-data" class="form-update">
            <h4>Changement du nom utilisateur : <label> <input type="text" name="name" value="<?php echo htmlspecialchars($userInformation['nom_utilisateur']); ?>"></label></h4>
            <h4>Changement du mail : <label> <input type="email" name="mail" value="<?php echo htmlspecialchars($userInformation['email']); ?>"></label></h4>
            <h4>Changement du mot de passe : <label> <input type="password" name="password" value="<?php echo htmlspecialchars($userInformation['mot_de_passe']); ?>"></label></h4>
            <label>Changement d'avatar Avatar <input type="file" formenctype="multipart/form-data" name="avatar_change"></label>
            <button type="submit" name="update">Mettre à jour</button>
        </form>

        <?php
        if (isset($_POST['update'])) {
            $name = !empty($_POST['name']) ? $_POST['name'] : $userInformation['nom_utilisateur'];
            $email = !empty($_POST['mail']) ? $_POST['mail'] : $userInformation['email'];
            $password = $_POST['password'] ?? $userInformation['mot_de_passe'];
            $upload_file = $userInformation['avatar_url'];

            if (isset($_FILES['avatar_change']) && $_FILES['avatar_change']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = 'uploadsAvatar/';
                $unique_name = uniqid('imgAvatar_', true) . '.' . pathinfo($_FILES['avatar_change']['name'], PATHINFO_EXTENSION);
                $upload_file = $upload_dir . $unique_name;

                if (!move_uploaded_file($_FILES['avatar_change']['tmp_name'], $upload_file)) {
                    echo "Erreur lors de l'upload du fichier.";
                    $upload_file = $userInformation['avatar_url'];
                }
            }

            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            try {
                update_pseudo_run($_SESSION['pseudo'], $name);
                update_user($id, $name, $upload_file, $email, $password_hash);
                $_SESSION['pseudo'] = $name;
                $_SESSION['avatar_url'] = $upload_file;
                echo "<p>Compte modifié avec succès.</p>";
            } catch (DatabaseException $e) {
                echo json_encode(['error' => $e->getMessage()]);
                exit;
            } catch (Exception $e) {
                echo "Erreur : " . $e->getMessage();
            }
        }
        ?>


        <form method="post" action="">
            <button type="submit" name="delete">Supprimer le compte</button>
        </form>
        <?php
        if (isset($_POST['delete'])) {
            echo "<p>Compte supprimé.</p>";
            try {
                delete_user($id);
                session_destroy();
                header('Location: index.php');
            } catch (DatabaseException|Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
                exit;
            }
        }
        ?>
        <form method="post" action="">
            <button type="submit" name="deconnexion" class="deconnexion">Deconnexion</button>
        </form>


        <h2 class="settings-title">Apparence</h2>
        <form action="" method="post">
            <h4>Thème</h4>
            <label> Selection d'un thème :
                <select name="theme_selectionne">
                    <option value="">--Choix du thème--</option>
                    <?php foreach ($ListUserTheme as $theme) : ?>
                        <option value="<?php echo $theme['nom_theme']; ?>">
                            <?php echo $theme['nom_theme']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <button type="submit" name="changer_theme">Changer de thème</button>
        </form>

        <form method="post" action="">
            <label> Suppresion d'un thème :
                <select name="theme_delete">
                    <option value="">--Choix du thème--</option>
                    <?php foreach ($ListUserTheme as $theme) : ?>
                        <option value="<?php echo $theme['nom_theme']; ?>"><?php echo $theme['nom_theme']; ?></option>
                    <?php endforeach; ?>
                </select>

            </label>
            <button type="submit" name="delete_theme"> Suppresion thème</button>
            <?php
            if (isset($_POST['delete_theme'])) {
                $theme_delete = $_POST['theme_delete'] ?? '';
                $theme_delete = $_POST['theme_delete'] ?? '';
                if ($theme_delete) {
                    echo "<p>Thème supprimé : $theme_delete.</p>";
                    try {
                        delete_theme($theme_delete);
                    } catch (DatabaseException $e) {
                        echo json_encode(['error' => $e->getMessage()]);
                        exit;
                    } catch (Exception $e) {
                        echo "Erreur : " . $e->getMessage();
                    }
                } else {
                    echo "<p>Aucun thème sélectionné pour la suppression.</p>";
                }
            }
            if (isset($_POST['changer_theme'])) {
                $nom_theme_selectionne = $_POST['theme_selectionne'] ?? '';
                if (!empty($nom_theme_selectionne)) {
                    try {
                        $_SESSION['theme'] = $nom_theme_selectionne;
                        echo "<p>Thème changé avec succès.</p>";
                    } catch (Exception $e) {
                        echo "Erreur : " . $e->getMessage();
                    }
                } else {
                    echo "<p>Veuillez sélectionner un thème.</p>";
                }
            }

            ?>

        </form>
        <form action="" method="post">
            <h3 class="settings-title"> Date et heure</h3>
            <div class="settings-format">
                <h4>Unité de temps</h4>
                <label>
                    <select name="time_unit">
                        <option value="format1">12h, 12m, 12s</option>
                        <option value="format2">12:12:12</option>
                    </select>
                </label>
            </div>
            <div class="settings-format">
            <h4> Format de date</h4>
            <label>
                <select name="date_format">
                    <option value="format1"> dd/mm/yyyy</option>
                    <option value="format2">yyyy/mm/dd</option>
                    <option value="format3">12 Decembre 2024</option>
                </select>
            </label>
            </div>
            <button type="submit" name="submit_formats">Soumettre les formats</button>
        </form>
        <h2 class="settings-title">Confidentialité</h2>
        <form method="post" action="">
            <div class="radio-container">
            <h4>Visibilité du profil</h4>
            <div class="radio-group">
                <label><input type="radio" name="visibilite_profil"
                              value="0" <?php echo (isset($paramsUser['visibilite_profil']) && $paramsUser['visibilite_profil'] == "0") ? 'checked' : ''; ?>>
                    Public</label>
                <label><input type="radio" name="visibilite_profil"
                              value="1" <?php echo (isset($paramsUser['visibilite_profil']) && $paramsUser['visibilite_profil'] == "1") ? 'checked' : ''; ?>>
                    Privée</label>
            </div>
            </div>
            <div class="radio-container">
                <h4>Visibilité des statistiques</h4>
                <div class="radio-group">
                    <label><input type="radio" name="visibilite_stats"
                                  value="0" <?php echo (isset($paramsUser['visibilite_stats']) && $paramsUser['visibilite_stats'] == "0") ? 'checked' : ''; ?>>
                        Public</label>
                    <label><input type="radio" name="visibilite_stats"
                                  value="1" <?php echo (isset($paramsUser['visibilite_stats']) && $paramsUser['visibilite_stats'] == "1") ? 'checked' : ''; ?>>
                        Privée</label>
                </div>
            </div>
            <div class="radio-container">
            <h4>Visibilité des runs</h4>
            <div class="radio-group">
                <label><input type="radio" name="visibilite_run"
                              value="0" <?php echo (isset($paramsUser['visibilite_run']) && $paramsUser['visibilite_run'] == "0") ? 'checked' : ''; ?>>
                    Public</label>
                <label><input type="radio" name="visibilite_run"
                              value="1" <?php echo (isset($paramsUser['visibilite_run']) && $paramsUser['visibilite_run'] == "1") ? 'checked' : ''; ?>>
                    Privée</label>
            </div>
            </div>
            <div class="radio-container">

            <h4>Visibilité des commentaires</h4>
            <div class="radio-group">

                <label><input type="radio" name="visibilite_commentaire"
                              value="0" <?php echo (isset($paramsUser['visibilite_commentaire']) && $paramsUser['visibilite_commentaire'] == "0") ? 'checked' : ''; ?>>
                    Public</label>
                <label><input type="radio" name="visibilite_commentaire"
                              value="1" <?php echo (isset($paramsUser['visibilite_commentaire']) && $paramsUser['visibilite_commentaire'] == "1") ? 'checked' : ''; ?>>
                    Privée</label>
            </div>
            </div>
<!--            <div class="radio-container">
            <h4>Ne pas autoriser les autres à m'envoyer des messages privés</h4>
            <div class="radio-group">

                <label><input type="radio" name="pas_message_prive"
                              value="0" <?php echo (isset($paramsUser['pas_message_prive']) && $paramsUser['pas_message_prive'] == "0") ? 'checked' : ''; ?>>
                    Autorisé</label>
                <label><input type="radio" name="pas_message_prive"
                              value="1" <?php echo (isset($paramsUser['pas_message_prive']) && $paramsUser['pas_message_prive'] == "1") ? 'checked' : ''; ?>>
                    Non autorisé</label>
            </div>
            </div>
            <div class="radio-container">

            <h4>Ne pas autoriser les commentaires</h4>
            <div class="radio-group">

                <label><input type="radio" name="pas_commentaire"
                              value="0" <?php echo (isset($paramsUser['pas_commentaire']) && $paramsUser['pas_commentaire'] == "0") ? 'checked' : ''; ?>>
                    Autorisé</label>
                <label><input type="radio" name="pas_commentaire"
                              value="1" <?php echo (isset($paramsUser['pas_commentaire']) && $paramsUser['pas_commentaire'] == "1") ? 'checked' : ''; ?>>
                    Non autorisé</label>
            </div>
            </div> -->
            <button type="submit">Enregistrer les modifications</button>
        </form>
    </div>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $biographie = $_POST['biographie'] ?? $paramsUser['biographie'];
    $pronoun = $_POST['pronoun'] ?? $paramsUser['pronoun'];
    $affichage_localisation = $_POST['affichage_localisation'] ?? $paramsUser['affichage_localisation'];
    $localisation = $_POST['localisation'] ?? $paramsUser['localisation'];
    $unite_temps = $_POST['time_unit'] ?? $paramsUser['unite_temps'];
    $format_date = $_POST['date_format'] ?? $paramsUser['format_date'];
    $visibilite_profil = $_POST['visibilite_profil'] ?? $paramsUser['visibilite_profil'];
    $visibilite_stats = $_POST['visibilite_stats'] ?? $paramsUser['visibilite_stats'];
    $visibilite_run = $_POST['visibilite_run'] ?? $paramsUser['visibilite_run'];
    $visibilite_commentaire = $_POST['visibilite_commentaire'] ?? $paramsUser['visibilite_commentaire'];
    $pas_message_prive = $_POST['pas_message_prive'] ?? $paramsUser['pas_message_prive'];
    $pas_commentaire = $_POST['pas_commentaire'] ?? $paramsUser['pas_commentaire'];
    $_SESSION['unite_temps'] = $unite_temps;
    $_SESSION['format_date'] = $format_date;
    try {
        update_params_player($id, $biographie, $pronoun, $affichage_localisation, $localisation, $unite_temps, $format_date, $visibilite_profil, $visibilite_stats, $visibilite_run, $visibilite_commentaire, $pas_message_prive, $pas_commentaire, $id);
        echo "<p>Paramètres enregistrés avec succès.</p>";
    } catch (DatabaseException $e) {
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

?>
<?php else: ?>
    <?php header('Location: index.php'); ?>
<?php endif; ?>
<style>


    .settings {
        max-width: 800px;
        margin: 20px auto;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .settings-title {
        font-size: 24px;
        color: #555;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .same-line {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        color: #555;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="file"],
    textarea,
    select {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    textarea {
        height: 100px;
        resize: none;
    }

    button {
        background: white;
        color: black;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 16px;
        transition: background 0.3s ease;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: auto;
        min-width: 200px;
        max-width: 200px;
    }

    button:hover {
        background: #0056b3;
    }

    .radio-container {
        margin-bottom: 20px;
    }

    .radio-group {
        display: flex;
        gap: 15px;
    }

    .radio-group label {
        font-weight: normal;
    }

    .radio-group input {
        margin-right: 5px;
    }

    .settings-format {
        margin-bottom: 20px;
    }

    .settings-format h4 {
        margin-bottom: 10px;
    }


    .form-update {
        margin-top: 20px;
    }

    .form-update h4 {
        margin-bottom: 10px;
    }

    .form-update input {
        margin-bottom: 20px;
    }

    select {
        width: auto;
    }

    p {
        font-size: 14px;
        color: #888;
        margin-top: 10px;
    }

    .deconnexion {
        background: red;
        color: white;
    }

    .deconnexion:hover {
        background: #a71d2a;
    }

    /* Custom theme section */
    .theme-section {
        margin-top: 30px;
    }
</style>