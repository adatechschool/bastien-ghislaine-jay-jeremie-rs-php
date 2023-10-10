<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mes abonnements</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <header>
        <?php
        include 'header.php';
        ?>
    </header>
    <div id="wrapper">
        <aside>
            <img src="user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3 class="fw-bold">Présentation</h3>
                <p class="fw-light">Sur cette page vous trouverez la liste des personnes dont
                    l'utilisatrice
                    n° <?php echo intval($_GET['user_id']) ?>
                    suit les messages
                </p>

            </section>
        </aside>
        <main class='contacts'>
            <?php
            if ($_SESSION['connected_id']) {
                // Etape 1: récupérer l'id de l'utilisateur
                $userId = intval($_GET['user_id']);
                // Etape 2: se connecter à la base de donnée
                include 'logingSQL.php';
                // Etape 3: récupérer le nom de l'utilisateur
                $laQuestionEnSql = "
                    SELECT users.* 
                    FROM followers 
                    LEFT JOIN users ON users.id=followers.followed_user_id 
                    WHERE followers.following_user_id='$userId'
                    GROUP BY users.id
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);

                while ($follower = $lesInformations->fetch_assoc()) {
            ?>
                    <article>
                        <img src="user.jpg" alt="blason" />
                        <h3 class="fw-bold"><?php echo $follower['alias'] ?></h3>
                        <p class="fw-light">id:<?php echo $follower['id'] ?></p>
                        <footer class="grid gap-0 row-gap-3">
                            <small>
                                <h5><button class="badge bg-danger">Se désabonner</button></h5>
                            </small>
                        </footer>
                    </article>
                <?php } ?>
            <?php
            } else {
            ?> <article> <?php echo 'Merci de vous connecter !!'; ?> </article>
            <?php
            }; ?>
        </main>
    </div>
</body>

</html>