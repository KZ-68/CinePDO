<?php
ob_start();
// démarre la temporisation de sortie
?>

<?php

if ($actor = $actor->fetch()) {
    
    // détail de l'acteur
    echo "<div class='card_website'>
    <a href='index.php?action=updateActorsForm&id={$actor['id_personne']}'>
    <h3>Modifier cet acteur</h3>
    </a></p>
    
    <img class='photoPerson' src='public/image/{$actor["photo"]}'<br/>
        Prénom et Nom de l'acteur : {$actor["prenom"]} {$actor["nom"]}<br/>
        Sexe : {$actor["sexe"]}<br/>
        Date de naissance : {$actor["date_naissance"]}</p>
    </div>";

    // liste des films de cet acteur
?>
<h4>Filmographie de l'acteur</h4>
<section class="section_actor1">
<?php  
    while ($film = $filmsActor->fetch()) {
        echo "<figure class='figure_film'>
        <img class='posterMovie' src='./public/image/{$film['affiche_film']}'>
        "
    ?>
        <a class='link_film' href='index.php?action=detailFilm&id=<?=$film['id_film']?>'>
        <h5><?=$film['titre']?></h5></a>
    <?php
        echo "</figcaption>
        </figure>";
    }
}
?>
</section>

<?php
 
$title = "Détails de l'acteur";
$content = ob_get_clean();
require "views/template.php"
?>