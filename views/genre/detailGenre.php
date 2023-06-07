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
    
?>
<h4>Films appartenant à ce genre</h4>
<section class="section_role">
<?php  
    while ($film = $films->fetch()) {
        echo "<figure class='figure_film'>
        {$film["affiche_film"]}"
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
 
$title = "Détails du genre "; 
$content = ob_get_clean();
require "views/template.php"
?>
