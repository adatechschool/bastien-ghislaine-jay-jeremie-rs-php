<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mes abonnés </title>
    <meta name="author" content="Julien Falconnet">
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
                <h3>Présentation des abonné.e.s</h3>
                <p>Sur cette page vous trouverez la liste des personnes qui vous suivent.</p>

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
                    LEFT JOIN users ON users.id=followers.following_user_id
                    WHERE followers.followed_user_id='$userId'
                    GROUP BY users.id
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);

            ?>
                <article>
                    <img src="user.jpg" alt="blason" />
                    <h3>Béatrice</h3>
                    <p>id:321</p>
                </article>
            <?php
            } else {
            ?> <article> <?php echo 'Merci de vous connecter !!'; ?> </article>
            <?php
            }; ?>
        </main>
    </div>
</body>

</html>