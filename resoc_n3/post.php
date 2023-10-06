<?php

// Si recois requete Post pour liker un post 
$traitementLike = isset($_POST['like'], $_POST['postIdtoLike']);
if ($traitementLike) {
    $sessionId = $_SESSION['connected_id'];
    $postId = $_POST['postIdtoLike'];
    $sessionId = intval($mysqli->real_escape_string($sessionId));
    $postId = intval($mysqli->real_escape_string($postId));

    $sql = "SELECT * FROM likes WHERE user_id = $sessionId AND post_id = $postId";
    $result = $mysqli->query($sql);

    if ($result->num_rows == 0) {

        $lInstructionSql = "INSERT INTO likes "
            . "(id, user_id, post_id) "
            . "VALUES (NULL, "
            . $sessionId . ", "
            . $postId . ");";
        echo $lInstructionSql;

        $ok = $mysqli->query($lInstructionSql);
        if (!$ok) {
            echo "Impossible de liker ce post :" . $mysqli->error;
        }
    }
}

// si recois requete Post pour unliker un post 
$traitementUnlike = isset($_POST['unlike'], $_POST['postIdtoUnlike']);
if ($traitementUnlike) {
    $sessionId = $_SESSION['connected_id'];
    $postId = $_POST['postIdtoUnlike'];

    $sessionId = intval($mysqli->real_escape_string($sessionId));
    $postId = intval($mysqli->real_escape_string($postId));

    $sql = "DELETE FROM likes WHERE user_id =" . $sessionId . " AND post_id =" . $postId . ";";

    $ok = $mysqli->query($sql);
    if (!$ok) {
        echo "Impossible de déliker ce post :" . $mysqli->error;
    }
}
?>

<article class="p-4">
    <h3>
        <time><?php echo $post['created'] ?></time>
    </h3>
    <address>par <a href="wall.php?user_id=<?php echo $post['author_id'] ?>"><?php echo $post['author_name'] ?></a> </address>
    <div>
        <p>
            <?php echo $post['content'] ?>
        </p>
    </div>
    <footer class="grid gap-0 row-gap-3">
        <small class="p-2">
            <h5><span class="badge rounded-pill text-bg-success">♥ <?php echo $post['like_number'] ?></span></h5>

            <!-- Si usilisateur connecté  -->

        </small>


        <?php
        // requete pour savoir si le poste est liké
        if (!empty($_SESSION['connected_id'])) {
            $sessionId = $_SESSION['connected_id'];
            $postIdtoCheck = $post['post_id'];

            $lInstructionLikeSql = "
        SELECT EXISTS(
            SELECT * FROM likes 
            WHERE user_id = '$sessionId' AND post_id = '$postIdtoCheck'
        ) AS isLiked";
            $lesInformationsLike = $mysqli->query($lInstructionLikeSql);
            $isLiked = $lesInformationsLike->fetch_assoc();
            //Si deja liké
            if ($isLiked['isLiked']) {
                //bouton grise "Liké"
        ?>
                <small class="mx-1">
                    <form action="<?php echo $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] ?>" method="post">
                        <input type='hidden' name='unlike' value='true'>
                        <input type='hidden' name='postIdtoUnlike' value=<?php echo $post['post_id'] ?>>
                        <button type="submit" class="btn btn-outline-secondary">Liké</button>
                    </form>
                </small>
            <?php
                //bouton warning déliké
                //à coder
            } else { //Si pas encore liké
            ?>
                <small class="mx-1">
                    <!-- formulaire bouton pour liker à refactoré  -->
                    <form action="<?php echo $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] ?>" method="post">
                        <input type='hidden' name='like' value='true'>
                        <input type='hidden' name='postIdtoLike' value=<?php echo $post['post_id'] ?>>
                        <button class="btn btn-primary" type='submit' value="Like">Like</button>
                    </form>
                </small>
        <?php

            }
        }

        $tagsArray = explode(',', $post['taglist']);
        $count = count($tagsArray);
        foreach ($tagsArray as $key => $tag) {
            echo '<a href="">' . $tag . '</a>';

            if ($key < $count - 1) {
                echo ', ';
            }
        }
        ?>

    </footer>
</article>