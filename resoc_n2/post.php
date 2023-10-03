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