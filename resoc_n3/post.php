<?php
//echo "<pre>" . print_r($post, 1) . "</pre>";
//echo "<pre>" . print_r($_SESSION['connected_id'], 1) . "</pre>"
?>

<article class="p-4">
    <h3>
        <time><?php echo $post['created'] ?></time>
    </h3>
    <address>par <a href="wall.php?user_id=<?php echo $post['author_id'] ?>"><?php echo $post['author_name'] ?></a> </address>
    <div>
        <p class="lh-sm">
            <?php echo $post['content'] ?>
        </p>
    </div>
    <footer class="grid gap-0 row-gap-3">
        <small class="p-2">


            <?php
            // requete pour savoir si le poste est liké
            if ($_SESSION['connected_id']) {

                $sessionId = $_SESSION['connected_id'];
                $postIdtoCheck = $post['post_id'];

                $lInstructionLikeSql = "
        SELECT EXISTS(
            SELECT * FROM likes 
            WHERE user_id = '$sessionId' AND post_id = '$postIdtoCheck'
        ) AS isLiked";
                $lesInformationsLike = $mysqli->query($lInstructionLikeSql);
                $isLiked = $lesInformationsLike->fetch_assoc();

                if ($isLiked['isLiked']) {
            ?>
                    <h5>
                        <button class="badge rounded-pill text-bg-success" data-post-id=<?php echo $post['post_id']; ?> data-user-id=<?php echo $sessionId; ?>>
                            <span>♥ <span class="likes_count<?php echo $post['post_id']; ?>">
                                    <?php echo $post['like_number'] ?>
                                </span></span>
                        </button>
                    </h5>
        </small>
    <?php
                } else {
    ?>
        <h5>
            <button class="badge rounded-pill text-bg-secondary" data-post-id=<?php echo $post['post_id']; ?> data-user-id=<?php echo $sessionId; ?>>
                <span>♥ <span class="likes_count<?php echo $post['post_id']; ?>"><?php echo $post['like_number'] ?></span></span>
            </button>
        </h5>
        </small>

    <?php
                }
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.text-bg-success, .text-bg-secondary').click(function() {
                var data = {
                    post_id: $(this).data('post-id'),
                    user_id: $(this).data('user-id'),
                    status: $(this).hasClass('text-bg-success') ? 'text-bg-success' : 'text-bg-secondary',
                };

                $.ajax({
                    url: 'script/postScript.php',
                    type: 'post',
                    data: data,
                    dataType: 'json', // Indiquer que vous attendez une réponse JSON
                    success: function(response) {
                        var post_id = data['post_id'];
                        var likeButton = $(".badge[data-post-id=" + post_id + "]");

                        // Utiliser directement la réponse JSON
                        var newLikesCount = response.likes_count;

                        // Mettre à jour le nombre de likes affiché sur le bouton
                        likeButton.find('.likes_count' + post_id).text(newLikesCount);

                        // Changer la couleur du bouton en fonction du statut
                        if (response.action === "new") {
                            likeButton.removeClass('text-bg-secondary').addClass('text-bg-success');
                        } else if (response.action === "delete") {
                            likeButton.removeClass('text-bg-success').addClass('text-bg-secondary');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur de requête AJAX :', status, error);
                    }
                });

            });
        });
    </script>
<?php
            } else {
?>

    <h5>
        <button class="badge rounded-pill text-bg-secondary" data-post-id=<?php echo $post['post_id']; ?>>
            <span>♥ <span class="likes_count<?php echo $post['post_id']; ?>"><?php echo $post['like_number'] ?></span></span>
        </button>
    </h5>
    </small>

<?php
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