<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mes abonnements</title>
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
        <aside>
            <img src="user.jpg" alt="Portrait de l'utilisateur / utilisatrice" />
            <section>
                <h3 class="fw-bold">Présentation de vos abonnements</h3>
                <p class="fw-light">Sur cette page vous trouverez la liste des personnes et des mots-clefs dont vous suivez les messages.</p>

            </section>
        </aside>
        <main class='contacts'>
            <?php
            if ($_SESSION['connected_id']) {
                $userId = intval($_GET['user_id']);
                include 'logingSQL.php';

                $laQuestionEnSql = "
                    SELECT users.* 
                    FROM followers 
                    LEFT JOIN users ON users.id=followers.followed_user_id 
                    WHERE followers.following_user_id='$userId'
                    GROUP BY users.id
                ";
                $lesInformations = $mysqli->query($laQuestionEnSql);

                while ($follower = $lesInformations->fetch_assoc()) {
            ?>
                    <article>
                        <img src="user.jpg" alt="blason" />
                        <h3 class="fw-bold"><?php echo $follower['alias'] ?></h3>
                        <p class="fw-light">id:<?php echo $follower['id'] ?></p>
                        <footer class="grid gap-0 row-gap-3">
                            <small>
                                <h5><button class="badge bg-danger" data-follower-id="<?php echo $follower['id']; ?>" data-user-id="<?php echo $_SESSION['connected_id']; ?>">Se désabonner</button></h5>
                            </small>
                        </footer>

                    </article>
                <?php }
                ?>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('.bg-danger').click(function(e) {
                            e.preventDefault();

                            var button = $(this);
                            var data = {
                                follower_id: button.data('follower-id'),
                                user_id: button.data('user-id'),
                            };

                            $.ajax({
                                url: 'script/subscriptionsScript.php',
                                type: 'post',
                                data: data,
                                dataType: 'json',
                                success: function(response) {
                                    console.log(response.action);

                                    if (response.action === "unfollowed") {
                                        // Disable the button
                                        button.prop('disabled', true);
                                        // Change button text
                                        button.text('Désabonné');
                                        // Optionally, you can also update the button style
                                        button.removeClass('bg-danger').addClass('text-muted');
                                    }
                                },
                                error: function(error) {
                                    // Handle error
                                    console.error(error);
                                }
                            });
                        });
                    });
                </script>
            <?php
            } else {
            ?>
                <article>
                    <?php echo 'Merci de vous connecter !!'; ?>
                </article>
            <?php }; ?>
        </main>
    </div>
</body>

</html>