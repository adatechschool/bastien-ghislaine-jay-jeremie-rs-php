<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mes abonnés </title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <header>
        <?php
        include 'header.php';
        ?>
    </header>
    <div id="wrapper">
        <aside>
            <!-- <img src="user.jpg" alt="Portrait de l'utilisatrice" /> -->
            <section>
                <h3>Présentation des abonné.e.s</h3>
                <p>Sur cette page, vous trouverez la liste des personnes qui vous suivent.</p>

            </section>
        </aside>
        <main class='contacts'>
            <?php
            if ($_SESSION['connected_id']) {
                // Etape 1: récupérer l'id de l'utilisateur
                $userId = intval($_SESSION['connected_id']);

                // Etape 2: se connecter à la base de donnée
                include 'logingSQL.php';

                // Etape 3: récupérer le nom de l'utilisateur
                $laQuestionEnSql = "
                    SELECT users.*
                    FROM followers
                    LEFT JOIN users ON users.id=followers.following_user_id
                    WHERE followers.followed_user_id='$userId'
                    GROUP BY users.id
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);

                // Etape 4: Afficher les informations pour chaque follower
                if ($lesInformations->num_rows != 0) {
                    while ($follower = $lesInformations->fetch_assoc()) {
            ?>
                        <article>
        <?php
        include 'userphoto.php';
        ?>
                            <h3 class="fs-4"> <a href="wall.php?user_id=<?php echo $follower['id'] ?>"><?php echo $follower['alias']; ?></a></h3>
                            <p>id: <?php echo $follower['id']; ?></p>
                        </article>
                    <?php
                    }
                } else { //si pas de followers
                    ?>
                    <article>
                        <img src="user.jpg" alt="blason" />
                        <h3 class="fs-4">Vous n'avez pas de followers !</h3>
                    </article>
                <?php
                }
            } else {
                ?>
                <article>
                    <?php echo 'Merci de vous connecter !!'; ?>
                </article>
            <?php
            }
            ?>
        </main>
    </div>
</body>

</html>