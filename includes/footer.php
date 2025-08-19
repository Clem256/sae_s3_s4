<?php
require_once 'function.php';
?>
<?php if (is_user_connected()): ?>
    <link rel="stylesheet" href="../style/CSS/style.php?version=<?php echo time(); ?>">
<?php else: ?>
    <link rel="stylesheet" href="../style/CSS/style.css?v=1.0">
<?php endif; ?>

<footer>
    <div class="legal-links">
        <h3><a href="../code/includes/legal_mention.php">Mentions légales</a></h3>
        <h3><a href="../code/includes/condition_utilisation.php">Conditions d'utilisation</a></h3>
        <h3><a href="../code/includes/Copyright.php">Copyright</a></h3>
    </div>
    <h5>Ce site web est développé dans le cadre d'un projet universitaire, et donc ce site n'a aucune intention de <br/>
        remplacer les sites déjà existants sur ce sujet.</h5>
</footer>

<style>
    footer {
        background-color: white;
        color: black;
        padding: 30px 20px;
        text-align: center;
        font-size: 1rem;
        margin-top: auto;
        width: 100%;
    }

    footer .legal-links {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
    }

    footer .legal-links h3 {
        margin: 0;
    }

    footer a {
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s ease, text-decoration 0.3s ease;
    }

    footer a:hover {
        text-decoration: underline;
    }

    footer h5 {
        font-size: 0.9rem;
        margin: 0;
        line-height: 1.5;
        color: black;
        padding-left: 50px ;
    }
    @media (max-width: 768px) {
        footer {
            font-size: 0.85rem;
            padding: 20px 15px;
        }

        footer .legal-links {
            flex-direction: column;
            gap: 10px;
        }
    }


</style>