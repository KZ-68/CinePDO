<?php
ob_start();
// démarre la temporisation de sortie
?>

<?php
if ($film = $film->fetch()) {

    echo "<div class='card_website'>
    <p>Titre du Film : {$film["titre"]}</p>
    <img class='posterMovie' src='./public/image/{$film['affiche_film']}'>
    <p>Date de sortie en France : {$film["sortieSalleFrance"]}</p>
    <p>Durée : {$film["tempsHeure"]}</p>
    <p>Réalisateur : {$film["affichageRea"]}</p>
    <p>Note : {$film["note"]}</p>
    <p>Synopsis :</p> <p class='synopsis'>{$film["synopsis"]}</p>
    </div>";
?>
    <h4>Acteurs de ce film</h4>
<section class="section_film1">
<?php    
    while ($actor = $actors->fetch()) {
        echo "<figure class='figure_actor'>
        <img class='photoPerson' src='public/image/{$actor["photo"]}'<br/>"
    ?>
        <a class='link_actor' href='index.php?action=detailActor&id=<?=$actor['id_acteur']?>'>
        <h5><?="{$actor["prenom"]} {$actor["nom"]}"?></h5></a>
    <?php
        echo "</figcaption>
        </figure>";
    }
}
?>
</section>

<?php

$title = "Détails du film ";
$content = ob_get_clean();
require "views/template.php"
?>