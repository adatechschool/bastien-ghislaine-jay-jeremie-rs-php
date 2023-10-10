<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mur</title>
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

        $userId = intval($_GET['user_id']);

        include 'logingSQL.php';
        ?>

        <aside>
            <?php
            /**
             * Etape 3: récupérer le nom de l'utilisateur
             */
            $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $user = $lesInformations->fetch_assoc();

            ?>
            <img src="user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez tous les message de l'utilisatrice : <a href="wall.php?user_id=<?php echo $user['id'] ?>"><?php echo $user['alias'] ?></a>
                    (n° <?php echo $userId ?>)
                </p>
            </section>
        </aside>
        <main>
            <?php
            $sessionId = $_SESSION['connected_id'];

            if ($sessionId == $userId) {

                $enCoursDeTraitement = isset($_POST['message']);
                if ($enCoursDeTraitement) {
                    $authorId = $sessionId;
                    $postContent = $_POST['message'];
                    // petite sécurité
                    $authorId = intval($mysqli->real_escape_string($authorId));
                    $postContent = $mysqli->real_escape_string($postContent);
                    //construction de la requete
                    $lInstructionSql = "INSERT INTO posts "
                        . "(id, user_id, content, created, parent_id) "
                        . "VALUES (NULL, "
                        . $authorId . ", "
                        . "'" . $postContent . "', "
                        . "NOW(), "
                        . "NULL);";
                    echo $lInstructionSql;
                    // execution
                    $ok = $mysqli->query($lInstructionSql);
                    if (!$ok) {
                        echo "Impossible d'ajouter le message: " . $mysqli->error;
                    }
                }
            ?>
                <article>
                    <form action="wall.php?user_id=<?php echo $sessionId ?>" method="post">
                        <input type='hidden' name='???' value='achanger'>
                        <dl>
                            <dt><label for='message'>Ecrivez votre post</label></dt>
                            <dd><textarea name='message'></textarea></dd>
                        </dl>
                        <input type='submit'>
                    </form>
                </article>
            <?php
            } elseif (($sessionId) && ($sessionId != $userId)) {

                $enCoursDeTraitement = isset($_POST['suivre']);
                if ($enCoursDeTraitement) {
                    $userFollowedId = $userId;
                    $userFollowingId = $sessionId;

                    $userFollowedId = intval($mysqli->real_escape_string($userFollowedId));
                    $userFollowingId = intval($mysqli->real_escape_string($userFollowingId));

                    $lInstructionSql = "INSERT INTO followers"
                        . "(id, followed_user_id, following_user_id) "
                        . "VALUES (NULL, "
                        . $userFollowedId . ", "
                        . $userFollowingId . ");";
                    echo $lInstructionSql;

                    $ok = $mysqli->query($lInstructionSql);
                    if (!$ok) {
                        echo "Impossible de suivre cet utilisateur" . $mysqli->error;
                    }
                }
            ?>
                <article>
                    <form action="wall.php?user_id=<?php echo $userId ?>" method="post">
                        <input type='hidden' name='suivre' value='true'>
                        <input type='submit' value="Suivre">
                    </form>
                </article>

            <?php
            }


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
                    WHERE posts.user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";

            $lesInformations = $mysqli->query($laQuestionEnSql);
            if (!$lesInformations) {
                echo ("Échec de la requete : " . $mysqli->error);
            }

            while ($post = $lesInformations->fetch_assoc()) {

                include 'post.php';
            } ?>

        </main>
    </div>
</body>

</html>