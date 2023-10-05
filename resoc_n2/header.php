<?php
session_start();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<img src="resoc.jpg" alt="Logo de notre réseau social" />
<nav id="menu">
    <a href="news.php">Actualités</a>
    <a href="wall.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mur</a>
    <a href="feed.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Flux</a>
    <a href="tags.php?tag_id=1">Mots-clés</a>
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