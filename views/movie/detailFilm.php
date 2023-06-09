<?php
ob_start();
// démarre la temporisation de sortie
?>

<?php
if ($film = $film->fetch()) {

    echo "<div class='card_website'>
    <p>Titre du Film : {$film["titre"]}
    <a href='index.php?action=updateFilmsForm&id={$film['id_film']}'>
    <h3>Modifier ce Film</h3>
    </a></p>
    <img class='posterMovie' src='./public/image/{$film['affiche_film']}'>
    <p>Date de sortie en France : {$film["sortieSalleFrance"]}</p>
    <p>Durée : {$film["tempsHeure"]}</p>
    Genre :";
    while ($genre = $genreFilm->fetch()) {
        ?>
         <a href='index.php?action=detailGenre&id=<?=$genre['id_genre']?>'>
         <?=$genre["libelle"]?></a>
        <?php
    }

    echo 
        "<p>Note : {$film["note"]}</p>
        <p>Synopsis :</p> <p class='synopsis'>{$film["synopsis"]}</p>
    </div>";

    echo "<h4>Acteurs de ce film</h4>
    <section class='section_film1'>";   
    
    /* Pour ne pas tomber sur l'erreur "Call to a member function fetch() on array", 
    la variable qui vas être associée a un array où l'on cherche -> à récupérer les colonnes par la fonction fetch(), 
    doit impérativement être différente */
    while ($actor = $actorsFilm->fetch()) {
        ?>
        <figure class='figure_actor'>
            <img class='photoPerson' src='public/image/<?=$actor["photo"]?>'><br/>
            <a class="figure_anchors" href='index.php?action=detailActor&id=<?=$actor['id_personne']?>'>
            <h5><?=$actor["prenom"]?> <?=$actor["nom"]?></h5></a>
            <h6 class="movie_h6">Rôle : <?=$actor['nom_role']?></h6>
        </figure>
        <?php
    }

    if ($director = $directorFilm->fetch()) {
        ?>
        <h4>Réalisateur de ce film</h4>
        <figure class='figure_director'>
            <img class='photoPerson' src='public/image/<?=$director["photo"]?>'><br/>
            <a class="figure_anchors" href='index.php?action=detailDirector&id=<?=$director['id_film']?>'>
            <h5><?=$director["affichageRea"]?></h5></a>
        </figure>
        <?php
    }

}
?>
</section>

<?php

$title = "Détails du film ";
$content = ob_get_clean();
require "views/template.php"
?>