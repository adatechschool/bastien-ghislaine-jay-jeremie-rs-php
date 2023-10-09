<?php

require '../logingSQL.php';

// Assurez-vous que les données sont définies et non vides
if (isset($_POST["post_id"], $_POST["user_id"], $_POST["status"])) {
    $post_id = $_POST["post_id"];
    $user_id = $_POST["user_id"];
    $status = $_POST["status"];

    // Utilisez des requêtes préparées pour éviter les injections SQL
    $ratingQuery = mysqli_prepare($mysqli, "SELECT * FROM likes WHERE post_id = ? AND user_id = ?");
    mysqli_stmt_bind_param($ratingQuery, "ii", $post_id, $user_id);
    mysqli_stmt_execute($ratingQuery);
    $ratingResult = mysqli_stmt_get_result($ratingQuery);

    // Vérifiez si une ligne existe dans le résultat
    if (mysqli_num_rows($ratingResult) > 0) {
        // La ligne existe
        $action = '';

        if ($status == 'text-bg-success') {
            // Unlike le post
            mysqli_query($mysqli, "DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id");
            $action = 'delete';
        } else {
            // Vous n'avez pas besoin de fetch_assoc ici car vous avez déjà fait cela
            $action = 'Already liked';
        }

        // Obtenir le nombre total de likes après l'action
        $newLikesCount = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(*) as count FROM likes WHERE post_id = $post_id"))['count'];

        // Construire la réponse JSON
        $response = array(
            'action' => $action,
            'likes_count' => $newLikesCount,
        );

        // Envoyer la réponse JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Aucune ligne trouvée
        if ($status == 'text-bg-secondary') {
            // Like le post
            mysqli_query($mysqli, "INSERT INTO likes (user_id, post_id) VALUES ($user_id, $post_id)");
            $newLikesCount = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(*) as count FROM likes WHERE post_id = $post_id"))['count'];

            // Construire la réponse JSON
            $response = array(
                'action' => 'new',
                'likes_count' => $newLikesCount,
            );

            // Envoyer la réponse JSON
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            echo "Invalid status";
        }
    }

    // Fermez la requête préparée
    mysqli_stmt_close($ratingQuery);
} else {
    echo "Incomplete data";
}
