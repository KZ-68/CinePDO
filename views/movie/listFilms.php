<?php
ob_start();
// démarre la temporisation de sortie
?>


<h2>Liste des films</h2>


<?= $films->rowcount() ?>

<?php
while ($film = $films->fetch()) {

    echo "<p>{$film["id_film"]}</p>";

    echo "<p>Titre du Film : {$film["titre"]}</p>";

    echo "<img class='posterMovie' src='{$film["affiche_film"]}'>";

    echo "<p>Date de sortie en France : {$film["sortieSalleFrance"]}</p>";

    echo "<p>Durée : {$film["tempsHeure"]}</p>";

    echo "<p>Note : {$film["note"]}</p>";

    echo "<p>{$film["synopsis"]}</p>";
?>
    <a href="index.php?action=detailFilm&id=<?=$film['id_film']?>">Detail Film</a>
<?php
}

?>
<?php

$title = "Liste des films "; 
$content = ob_get_clean();
require "views/template.php"
?>