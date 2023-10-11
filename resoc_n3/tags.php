<<<<<<< HEAD
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
        $tagId = intval($_GET['tag_id']);
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
            $laQuestionEnSql = "SELECT * FROM `tags` WHERE id= '$tagId' ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $tagChoisi = $lesInformations->fetch_assoc();

            $tagParPost = "SELECT * FROM tags ORDER BY label";
            $listeDesTags = $mysqli->query($tagParPost);

            //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par le label et effacer la ligne ci-dessous
            //echo "<pre>" . print_r($tag, 1) . "</pgire>";
            ?>
            <section>
                <h3>Présentation des mots-clefs suivis</h3>
                <p>Sur cette page vous trouverez les derniers messages comportant les mots-clés suivis.</p>
                <?php while($tagList = $listeDesTags->fetch_assoc()) { ?>
                <div class="motHashTag">               
                <a href=""><i> <?php echo $tagList['label'] ?> </i></a>
                </br>  
            </div> 
                <?php };?>
                <!-- <?php echo $tagId ?>) -->
            </section>
        </aside>
        <main>
            <article class="container">
                <div class="row">
                    <div class="col text-start text-capitalize h4">
                        #<?php echo $tag['label'];
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
                    WHERE filter.tag_id ='$tagId' 
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

        </main>
    </div>
</body>

=======
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Les message par mot-clé</title>
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
        <?php
        /**
         * Cette page est similaire à wall.php ou feed.php 
         * mais elle porte sur les mots-clés (tags)
         */
        /**
         * Etape 1: Le mur concerne un mot-clé en particulier
         */
        $tagId = intval($_GET['tag_id']);
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
            $laQuestionEnSql = "SELECT * FROM tags WHERE id= '$tagId' ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $tag = $lesInformations->fetch_assoc();
            //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par le label et effacer la ligne ci-dessous
            //echo "<pre>" . print_r($tag, 1) . "</pre>";
            ?>
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez les derniers messages comportant
                    le mot-clé <?php echo $tag['label'] ?>
                    (n° <?php echo $tagId ?>)
                </p>

            </section>
        </aside>
        <main>
            <?php
            /**
             * Etape 3: récupérer tous les messages avec un mot clé donné
             */
            $laQuestionEnSql = "
                    SELECT posts.content,
                    posts.created,
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
                    WHERE filter.tag_id = '$tagId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            if (!$lesInformations) {
                echo ("Échec de la requete : " . $mysqli->error);
            }

            /**
             * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
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

        </main>
    </div>
</body>

>>>>>>> fbe7a44 (create userphoto.php and links to this file in the different pages)
</html>