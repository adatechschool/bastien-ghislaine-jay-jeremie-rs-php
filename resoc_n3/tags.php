<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Les messages par mot-clé</title>
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
        /**
         * Cette page est similaire à wall.php ou feed.php 
         * mais elle porte sur les mots-clés (tags)
         */
        /**
         * Etape 1: Le mur concerne un mot-clé en particulier
         */

        $tagIdDisplay = intval($_GET['tag_id']);

        ?>
        <?php
        /**
         * Etape 2: se connecter à la base de donnée
         */
        include 'logingSQL.php';
        ?>

        <aside>
            <?php
            /**
             * Etape 3: récupérer le nom du mot-clé
             */
            $laQuestionEnSql = "SELECT * FROM `tags` WHERE id= '$tagIdDisplay' ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $tagChoisi = $lesInformations->fetch_assoc();

            $tagParPost = "SELECT * FROM tags ORDER BY label";
            $listeDesTags = $mysqli->query($tagParPost);

            //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par le label et effacer la ligne ci-dessous
            //echo "<pre>" . print_r($tag, 1) . "</pgire>";
            ?>
            <section>
                <h3>Présentation des mots-clefs</h3>
                <p>Sur cette page vous trouverez les derniers messages comportant les mots-clés suivis.</p>
                <ul class="list-group motHashTag">
                    <?php while ($tagList = $listeDesTags->fetch_assoc()) {
                        $tagId = $tagList['id'];
                        $RequetCountTagSQL = "SELECT COUNT(*) AS tagCount FROM posts_tags WHERE tag_id = $tagId";
                        $countTagResp = $mysqli->query($RequetCountTagSQL);

                        if ($countTagResp) {
                            $countTag = $countTagResp->fetch_assoc();
                            $tagCount = $countTag['tagCount'];
                        } else {
                            // Gérer l'erreur ici si nécessaire
                            $tagCount = 0;
                        }
                    ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <a href="tags.php?tag_id=<?php echo $tagId ?>" class="tag-link" data-tag-id="<?php echo $tagId ?>">
                                <i> <?php echo $tagList['label'] ?> </i>
                            </a>
                            <span class="badge bg-primary rounded-pill"><?php echo $tagCount; ?></span>
                        </li>
                    <?php }; ?>
                </ul>

                <!-- <?php echo $tagId ?>) -->
            </section>
        </aside>
        <main>
            <article class="container">
                <div class="row">
                    <div class="col text-start text-capitalize h4">
                        #<?php echo $tagChoisi['label'];
                            ?>
                    </div>
                    <div class="col text-end">
                        <button type="button" class="btn btn-primary">Suivre</button>
                    </div>
                </div>
            </article>
            <?php
            /**
             * Etape 3: récupérer tous les messages avec un mot clé donné
             */
            $laQuestionEnSql = "
                    SELECT posts.content,
                    posts.created,
                    posts.id as post_id,
                    users.alias as author_name,
                    users.id as author_id,    
                    count(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts_tags as filter 
                    JOIN posts ON posts.id=filter.post_id
                    JOIN users ON users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE filter.tag_id ='$tagIdDisplay' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            if (!$lesInformations) {
                echo ("Échec de la requete : " . $mysqli->error);
            }

            /**
             * Etape 4: @todo Parcourir les messages et remplir correctement le HTML avec les bonnes valeurs php
             */
            while ($post = $lesInformations->fetch_assoc()) {

                //echo "<pre>" . print_r($post, 1) . "</pre>";
            ?>
                <?php
                include 'post.php';
                ?>
            <?php
                // avec le <?php ci-dessus on retourne en mode php 
            } // cette accolade ferme et termine la boucle while ouverte avant.
            ?>

            <script>
                $(document).ready(function() {
                    $('.tag-link').click(function(e) {
                        e.preventDefault(); // Empêche le comportement de lien normal

                        // Récupère le tagId du lien cliqué
                        var tagId = $(this).data('tag-id');

                        // Envoie la requête POST
                        $.ajax({
                            url: 'script/tagsScript.php', // Remplacez par le chemin de votre script PHP qui traitera la requête POST
                            type: 'POST',
                            data: {
                                tag_id: tagId
                            },
                            success: function(response) {
                                // Traitez la réponse si nécessaire
                                console.log(response);
                                // Redirigez l'utilisateur vers la page avec le tag_id
                                window.location.href = 'tags.php?tag_id=' + tagId;
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
                    });
                });
            </script>



        </main>
    </div>
</body>




</html>