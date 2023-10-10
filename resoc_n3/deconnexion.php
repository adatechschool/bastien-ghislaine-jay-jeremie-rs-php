<?php
session_destroy();
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}
?>

<!-- session_destroy() détruit toutes les données associées avec la session courante. 
Cette fonction ne détruit pas les variables globales associées avec la session, de même, 
elle ne détruit pas le cookie de session. -->
<!-- Pour détruire complètement une session, l'identifiant de la session doit également être effacé. 
Si un cookie est utilisé pour propager l'identifiant de session (comportement par défaut), 
alors le cookie de session doit être effacé. La fonction setcookie() peut être utilisé pour cela. -->

<?php
include 'login.php';
?>