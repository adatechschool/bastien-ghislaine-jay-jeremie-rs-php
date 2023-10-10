<?php
session_start();
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Paramètres</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <header>
        <?php
        include 'header.php';
        ?>
    </header>
    <div id="wrapper" class='profile'>

    <?php 
    require_once 'logingSQL.php'; 
    // Vérifier si user_id est défini dans l'URL
    if (isset($_GET['user_id'])) {
        $userId = intval($_GET['user_id']);

        // Récupérer les données de l'image depuis la base de données
        $result = $mysqli->query("SELECT type, bin FROM images WHERE user_id = $userId ORDER BY id DESC LIMIT 1");

        if ($result !== false && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $imageData = base64_encode($row['bin']);
            $imageSrc = "data:" . $row['type'] . ";base64," . $imageData;
        } else {
            // Si l'utilisateur n'a pas de photo de profil personnalisée, utilisez une image par défaut
            $imageSrc = "chemin/vers/dossier/images/default.jpg";
        }
        } else {
        // Si user_id n'est pas défini dans l'URL, affichez un message d'erreur
        echo "L'identifiant de l'utilisateur n'est pas défini.";
    }
    ?>

        <aside>
            <?php if(isset($imageSrc)){ ?> 
                <div class="gallery"> 
                    <img src="<?php echo $imageSrc; ?>" alt="Portrait de l'utilisateur" />
                </div> 
            <?php }else{ ?> 
                 <p class="status error">Image not found...</p> 
            <?php } ?>
            <section>
                <h3>Présentation des paramètres</h3>
                <p>Sur cette page vous trouverez l'ensemble de vos informations.</p>

            </section>
        </aside>
        <main>
            <?php
            if ($_SESSION['connected_id']) {
                /**
                 * Etape 1: Les paramètres concernent une utilisatrice en particulier
                 * La première étape est donc de trouver quel est l'id de l'utilisatrice
                 * Celui ci est indiqué en parametre GET de la page sous la forme user_id=...
                 * Documentation : https://www.php.net/manual/fr/reserved.variables.get.php
                 * ... mais en résumé c'est une manière de passer des informations à la page en ajoutant des choses dans l'url
                 */
                $userId = intval($_GET['user_id']);

                /**
                 * Etape 2: se connecter à la base de donnée
                 */
                include 'logingSQL.php';

                /**
                 * Etape 3: récupérer le nom de l'utilisateur
                 */
                $laQuestionEnSql = "
                    SELECT users.*, 
                    count(DISTINCT posts.id) as totalpost, 
                    count(DISTINCT given.post_id) as totalgiven, 
                    count(DISTINCT recieved.user_id) as totalrecieved 
                    FROM users 
                    LEFT JOIN posts ON posts.user_id=users.id 
                    LEFT JOIN likes as given ON given.user_id=users.id 
                    LEFT JOIN likes as recieved ON recieved.post_id=posts.id 
                    WHERE users.id = '$userId' 
                    GROUP BY users.id
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if (!$lesInformations) {
                    echo ("Échec de la requete : " . $mysqli->error);
                }
                $user = $lesInformations->fetch_assoc();
            
                if (isset($_POST["valider"])) {
                    include 'logingSQL.php';
                
                    $image_name = $_FILES["image"]["name"];
                    $image_size = $_FILES["image"]["size"];
                    $image_type = $_FILES["image"]["type"];
                    $image_tmp_name = $_FILES["image"]["tmp_name"];
                    
                    // Vérifie la taille maximale de l'image (5 Mo)
                    if ($image_size <= 5 * 1024 * 1024) {
                        $image_bin = file_get_contents($image_tmp_name);
                
                        $sql = "INSERT INTO images (user_id, name, size, type, bin) VALUES (?, ?, ?, ?, ?)";
                        $stmt = $mysqli->prepare($sql);
                
                        if ($stmt) {
                            $stmt->bind_param("isiss", $userId, $image_name, $image_size, $image_type, $image_bin);
                            $stmt->execute();

                            if ($stmt->affected_rows > 0) {
                                echo "L'image a été téléchargée avec succès.";
                            } else {
                                echo "Une erreur s'est produite lors de l'insertion de l'image.";
                            }
                
                            $stmt->close();
                        } else {
                            echo "Erreur de préparation de la requête : " . $mysqli->error;
                        }
                        // Redirige l'utilisateur vers la page de paramètres après l'upload.
                        header("Location: settings.php?user_id=" . $userId);
                        exit();
                    } else {
                        // La taille de l'image dépasse la limite
                        echo "La taille de l'image dépasse la limite de 5 Mo.";
                    }
                }
                
            ?>
                <article class='parameters'>
                    <h3>Mes paramètres</h3>
                    <dl>
                        <dt>Pseudo</dt>
                        <dd><?php echo $user['alias'] ?></dd>
                        <dt>Email</dt>
                        <dd><?php echo $user['email'] ?></dd>
                        <dt>Nombre de message</dt>
                        <dd><?php echo $user['totalpost'] ?></dd>
                        <dt>Nombre de "J'aime" donnés </dt>
                        <dd><?php echo $user['totalgiven'] ?></dd>
                        <dt>Nombre de "J'aime" reçus</dt>
                        <dd><?php echo $user['totalrecieved'] ?></dd>
                        <dt>Photo de profil</dt>
                        <dd>
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="max_file-size" value="250000" />
                                <input type="file" name="image" /><br />
                                <input type="submit" name="valider" value="Sauvegarder" />
                            </form>
                </article>
            <?php
            } else {
            ?> <article> <?php echo 'Merci de vous connecter !!'; ?> </article>
            <?php
            }; ?>
        </main>
    </div>
</body>

</html>