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
        $sessionId = intval($_SESSION['connected_id']);
        $userId = intval($_GET['user_id']);

        include 'logingSQL.php';
        ?>

        <aside>
            <?php
            /**
             * Etape 3: récupérer le nom de l'utilisateur
             */
            
            include 'userphoto.php';
            ?>
            <section>
                <?php
                if ($sessionId == $userId) {
                ?>
                    <h3>Présentation de votre mur</h3>
                    <p>Sur cette page vous trouverez tous vos messages <i><?php echo $user['alias'] ?></i> !</p>
                <?php } else {
                ?>
                    <h3>Présentation du mur de <?php echo $user['alias'] ?></h3>
                    <p>Sur cette page vous trouverez tous les messages de <i><?php echo $user['alias'] ?></i> !</p>
                <?php
                } ?>
                
                <?php
                if (($_SESSION['connected_id']) && ($_SESSION['connected_id'] != $userId)) {
                    include 'wall/followBtn.php';
                };
                ?>
            </section>
        </aside>
        <main>
            <?php

            if ($sessionId == $userId) {

                $enCoursDeTraitement = isset($_POST['message']);
                if ($enCoursDeTraitement) {
                    $authorId = $sessionId;
                    $postContent = $_POST['message'];
                    $postContent = '<p>' . implode("</p><p>", (explode("\r\n", $postContent))) . '</p>';
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
                    // echo $lInstructionSql;
                    $pattern = '/#(\w+)\b/';
                    if (preg_match_all($pattern, $postContent, $matches)) {
                        foreach ($matches[1] as $match) {
                            $requeteSql = "SELECT label FROM tags WHERE label = '$match'";
                            $lesInfos = $mysqli->query($requeteSql);
                            if ($lesInfos !== false && $lesInfos->num_rows == 0) {
                                $lInstructionSqlTag = "INSERT INTO tags (id, label) VALUES (NULL, '$match')";
                                $ok = $mysqli->query($lInstructionSqlTag);
                            }
                        }

                        // execution
                        $ok = $mysqli->query($lInstructionSql);
                        if (!$ok) {
                            echo "Impossible d'ajouter le message: " . $mysqli->error;
                        }
                    }
                }
            ?>
                <article>
                    <form action="wall.php?user_id=<?php echo $sessionId ?>" method="post">
                        <input type='hidden' name='???' value='achanger'>
                        <dl>
                            <dt><label for='message'>Ecrivez votre post</label></dt>
                            <dd><textarea name='message' class='message custom-width'></textarea></dd>
                        </dl>
                        <div class='button-valider'> <input type='submit'></div>
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