<?php
session_start();
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<img src="logo-site.png" alt="Logo de notre réseau social" />
<nav id="menu">
    <a href="news.php">Actualités</a>
    <a href="wall.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mur</a>
    <a href="feed.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Flux</a>
    <a href="tags.php?tag_id=1">Mots-clés</a>
    <h1>CodéConneries</h1>
</nav>

<nav id="user">

    <?php if ($_SESSION['connected_id']) { ?>

        <a href="#">Profil</a>
        <ul>
            <li><a href="settings.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Paramètres</a></li>
            <li><a href="followers.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mes suiveurs</a></li>
            <li><a href="subscriptions.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mes abonnements</a></li>
        </ul>

    <?php
    } else {
    ?>
        <a href="login.php">Connexion</a>
    <?php } ?>

</nav>