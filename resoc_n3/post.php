<?php

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
        echo "Impossible de liker ce post" . $mysqli->error;
    }
    }
}
?>
<article>
    <h3>
        <time><?php echo $post['created'] ?></time>
    </h3>
    <address>par <a href="wall.php?user_id=<?php echo $post['author_id'] ?>"><?php echo $post['author_name'] ?></a> </address>
    <div>
        <p>
            <?php echo $post['content'] ?>
        </p>
    </div>
    <footer>
        <small>
            ♥ <?php echo $post['like_number'] ?>
            <form action="<?php echo $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] ?>" method="post">
                        <input type='hidden' name='like' value='true'>
                        <input type='hidden' name='postIdtoLike' value=<?php echo $post['post_id'] ?>>
                        <input type='submit' value="Like">
                    </form>
        </small>
        <?php
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