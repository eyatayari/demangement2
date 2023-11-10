<?php
require 'main.php';
var_dump($_POST);
if (isset($_POST['id']) && isset($_POST['newValue'])) {
    $id = $_POST['id'];
    $newValue = $_POST['newValue'];
    // Mettez à jour la valeur dans l'array en fonction de l'ID
    foreach (FOURNITURES as &$fourniture){
        foreach ($fourniture as &$element) {
            var_dump($_POST);

            if ($element['id'] == $id) {
            $element['qte'] = $newValue;
            break; // Sortez de la boucle une fois que vous avez mis à jour la valeur
        }
    }}

    // Vous pouvez sauvegarder la mise à jour dans votre source de données si nécessaire
    // ...
}

// Renvoyez une réponse, par exemple, la nouvelle valeur mise à jour
echo json_encode(['success' => true]);
