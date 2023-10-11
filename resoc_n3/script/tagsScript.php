<?php

if (isset($_POST['tag_id'])) {
    // Récupérer le tag_id
    $tagId = intval($_POST['tag_id']);

    // Vous pouvez faire d'autres traitements ici, par exemple mettre à jour des données côté serveur

    // Envoyer une réponse JSON (pour indiquer le succès ou l'échec)
    $response = array('status' => 'success', 'message' => 'Traitement réussi.');
    echo json_encode($response);
} else {
    // Envoyer une réponse JSON indiquant l'échec
    $response = array('status' => 'error', 'message' => 'Données manquantes.');
    echo json_encode($response);
}
