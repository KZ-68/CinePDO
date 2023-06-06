<?php
ob_start();
// démarre la temporisation de sortie
?>

<?php
if ($film = $film->fetch()) {

    echo "<div class='card_website'>
    <p>Titre du Film : {$film["titre"]}</p>
    <img class='posterMovie' src='{$film["affiche_film"]}'>
    <p>Date de sortie en France : {$film["sortieSalleFrance"]}</p>
    <p>Durée : {$film["tempsHeure"]}</p>
    <p>Réalisateur : {$film["affichageRea"]}</p>
    <p>Note : {$film["note"]}</p>
    <p>Synopsis :</p> <p class='synopsis'>{$film["synopsis"]}</p>
    </div>";

}
?>

<?php
 
$content = ob_get_clean();
require "views/template.php"
?>