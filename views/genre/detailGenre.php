<?php
ob_start();
// démarre la temporisation de sortie
?>

<?php

if ($genre = $genre->fetch()) {

    echo "<div class='card_website'>
    {$genre["id_genre"]}
    <p>Libellé du genre : {$genre["libelle"]}\n
    </div>";
    
}

    
?>

<?php
 
$content = ob_get_clean();
require "views/template.php"
?>
