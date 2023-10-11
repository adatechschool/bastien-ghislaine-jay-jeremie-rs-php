<?php
include '../logingSQL.php';
// check si suivis ou pas

$userFollowedId = intval($_GET['user_id']);
$userFollowingId = $_SESSION['connected_id'];

$userFollowedId = intval($mysqli->real_escape_string($userFollowedId));
$userFollowingId = intval($mysqli->real_escape_string($userFollowingId));

$checkFollowSql = "SELECT *
                   FROM followers
                   WHERE followed_user_id = $userFollowedId AND following_user_id = $userFollowingId";
//echo $checkFollowSql;

$ok = $mysqli->query($checkFollowSql);

if ($ok->num_rows == 0) {
?>

    <h5><button class="badge bg-success" data-follower-id="<?php echo $userFollowedId; ?>" data-user-id="<?php echo $userFollowingId; ?>">Suivre</button></h5>

<?php
} else {
?>

    <h5><button class="badge bg-secondary" data-follower-id="<?php echo $userFollowedId; ?>" data-user-id="<?php echo $userFollowingId; ?>">Suivi•e</button></h5>

<?php
}
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
                        // Change button text
                        button.text('Suivre');
                        // Optionally, you can also update the button style
                        button.removeClass('bg-success').addClass('badge bg-secondary');
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
//echo "<pre>" . print_r($result, 1) . "</pre>";

// Uncomment the logic for following if needed
/*
$enCoursDeTraitement = isset($_POST['suivre']);
if ($enCoursDeTraitement) {
    $userFollowedId = intval($mysqli->real_escape_string($userFollowedId));
    $userFollowingId = intval($mysqli->real_escape_string($userFollowingId));

    $lInstructionSql = "INSERT INTO followers (id, followed_user_id, following_user_id) "
                     . "VALUES (NULL, $userFollowedId, $userFollowingId);";
    echo $lInstructionSql;

    $ok = $mysqli->query($lInstructionSql);
    if (!$ok) {
        echo "Impossible de suivre cet utilisateur" . $mysqli->error;
    }
}
*/
?>

<!-- <article>
    <form action="wall.php?user_id=<?php echo $userId ?>" method="post">
        <input type='hidden' name='suivre' value='true'>
        <input type='submit' value="Suivre">
    </form>
</article> -->