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

<?php if (isset($imageSrc)) { ?>
  <div class="gallery">
    <img src="<?php echo $imageSrc; ?>" alt="Portrait de l'utilisateur" class="img-thumbnail" />
  </div>
<?php } else { ?>
  <p class="status error">Image not found...</p>
<?php } ?>













