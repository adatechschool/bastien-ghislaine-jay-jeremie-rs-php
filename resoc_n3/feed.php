<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Flux</title>
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
        <?php

        // recupère l'ID de l'utilisateur dont on regarde son mur
        $userId = intval($_GET['user_id']);
        ?>

        <?php
        include 'logingSQL.php';
        ?>

        <aside>
            <?php

            $laQuestionEnSql = "SELECT * FROM `users` WHERE id= '$userId' ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $user = $lesInformations->fetch_assoc();
            ?>

            <img src="user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez tous les message des utilisatrices
                    auxquel est abonnée l'utilisatrice <a href="wall.php?user_id=<?php echo $user['id'] ?>"><?php echo $user['alias'] ?></a>
                    (n° <?php echo $userId ?>)
                </p>

            </section>
        </aside>
        <main>
            <?php


            if (!empty($_SESSION['connected_id'])) {

                $laQuestionEnSql = "
                    SELECT posts.content, 
                    posts.created,
                    posts.id as post_id,
                    users.alias as author_name,
                    users.id as author_id, 
                    COUNT(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM followers 
                    JOIN users ON users.id=followers.followed_user_id
                    JOIN posts ON posts.user_id=users.id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE followers.following_user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if (!$lesInformations) {
                    echo ("Échec de la requete : " . $mysqli->error);
                }

                while ($post = $lesInformations->fetch_assoc()) {
                    include 'post.php';
                }
            } else {
            ?> <article> <?php echo 'Merci de vous connecter !!'; ?> </article>
            <?php
            }; ?>

        </main>
    </div>
</body>

</html>