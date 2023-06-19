<?php
ob_start();
// démarre la temporisation de sortie
?>

<?php

if ($genre = $genre->fetch()) {

    echo "<div class='card_website'>
    <a href='index.php?action=updateGenresForm&id={$genre['id_genre']}'>
    <h3>Modifier ce Genre</h3>
    </a></p>
    {$genre["id_genre"]}
    <p>Libellé du genre : {$genre["libelle"]}\n
    </div>";
    
?>
<h4>Films appartenant à ce genre</h4>
<section class="section_role">
<?php  
  
    while ($films = $filmsGenre->fetch()) {
        echo "<figure class='figure_film'>
        <img class='posterMovie' src='./public/image/{$films['affiche_film']}'>"
    ?>
        <a class='link_film' href='index.php?action=detailFilm&id=<?=$films['id_film']?>'>
        <h5><?=$films['titre']?></h5></a>
    <?php
        echo "</figcaption>
        </figure>";
    }

}
?>
</section>

<?php
 
$title = "Détails du genre "; 
$content = ob_get_clean();
require "views/template.php"
?>
