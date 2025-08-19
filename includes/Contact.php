<?php
require_once "header_footerpage.php";
require_once "../includes/function.php";
echo "Contact";
require_once "footer_footerpage.php";
?>
<?php if (is_user_connected()): ?>
    <link rel="stylesheet" href="../style/CSS/style.php?version=<?php echo time(); ?>">
<?php else: ?>
    <link rel="stylesheet" href="../style/CSS/style.css?v=1.0">
<?php endif; ?>
