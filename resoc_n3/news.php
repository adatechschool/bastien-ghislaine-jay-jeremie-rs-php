<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Actualités</title>
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
        <?php
        include 'userphoto.php'
        ?>
            <section>
<<<<<<< HEAD
                <h3>Présentation des actualités</h3>
                <p>Sur cette page vous trouverez les derniers messages de tous les utilisateurs / utilisatrices du site.</p>
=======
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez les informations de l'utilisatrice
                    n° <?php echo intval($_GET['user_id']) ?></p>
>>>>>>> fbe7a44 (create userphoto.php and links to this file in the different pages)
            </section>
        </aside>
        <main>

            <?php
            /*
                  // Documentation : les exemples https://www.php.net/manual/fr/mysqli.query.php
                  // plus généralement : https://www.php.net/manual/fr/mysqli.query.php
                 */

            // Etape 1: Ouvrir une connexion avec la base de donnée.
            include 'logingSQL.php';
            //verification
            if ($mysqli->connect_errno) {
                echo "<article>";
                echo ("Échec de la connexion : " . $mysqli->connect_error);
                echo ("<p>Indice: Vérifiez les parametres de <code>new mysqli(...</code></p>");
                echo "</article>";
                exit();
            }

            // Etape 2: Poser une question à la base de donnée et récupérer ses informations

            $laQuestionEnSql = "
                    SELECT posts.content,
                    posts.created,  
                    posts.id as post_id,
                    users.alias as author_name,
                    users.id as author_id,    
                    COUNT(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    LIMIT 5
                    ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            // Vérification
            if (!$lesInformations) {
                echo "<article>";
                echo ("Échec de la requete : " . $mysqli->error);
                echo ("<p>Indice: Vérifiez la requete  SQL suivante dans phpmyadmin<code>$laQuestionEnSql</code></p>");
                exit();
            }

            // Etape 3: Parcourir ces données et les ranger bien comme il faut dans du html
            while ($post = $lesInformations->fetch_assoc()) {

                include 'post.php';
            }
            ?>

        </main>
    </div>
</body>

</html>