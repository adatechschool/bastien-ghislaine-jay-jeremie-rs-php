<?php

require '../logingSQL.php';

if (isset($_POST["follower_id"], $_POST["user_id"])) {
    $follower_id = $_POST["follower_id"];
    $user_id = $_POST["user_id"];

    $follower_id = intval($mysqli->real_escape_string($follower_id));
    $user_id = intval($mysqli->real_escape_string($user_id));

    $lInstrctionSqlUnfollow = "DELETE FROM followers WHERE followed_user_id = ? AND following_user_id = ?";

    $stmt = $mysqli->prepare($lInstrctionSqlUnfollow);
    $stmt->bind_param("ii", $follower_id, $user_id);
    $ok = $stmt->execute();
    $stmt->close();

    if ($ok) {
        $action = "unfollowed";
        $response = array(
            'action' => $action,
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $error = mysqli_error($mysqli);
        $response = array(
            'error' => $error,
        );

        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
