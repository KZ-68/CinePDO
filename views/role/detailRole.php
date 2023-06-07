<?php
ob_start();
// démarre la temporisation de sortie
?>

<?php

if ($role = $role->fetch()) {

    echo "<div class='card_website'>
    <p>Nom du role joué : {$role["nom_role"]}\n
    </div>";
    
?>
<h4>Film où le rôle apparait</h4>
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
?>
</section>
<h4>Acteurs jouant ce rôle</h4>
<section class="section_role">
<?php    
    while ($actor = $actors->fetch()) {
        echo "<figure class='figure_actor'>
        {$actor["photo"]}"
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
 
$title = "Détails du role "; 
$content = ob_get_clean();
require "views/template.php"
?>