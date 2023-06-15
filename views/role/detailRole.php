<?php
ob_start();
// démarre la temporisation de sortie
?>

<?php

if ($role = $role->fetch()) {

?>
    <a href='index.php?action=editRoles&id=<?=$role['id_role']?>'>
    <h3>Editer Role</h3>
    </a>
<?php

    echo "<div class='card_website'>
    <p>Nom du role joué : {$role["nom_role"]}\n
    </div>";
    
?>
<h4>Film où le rôle apparait</h4>
<section class="section_role">
<?php  
    while ($film = $filmsRole->fetch()) {
        echo "<figure class='figure_film'>
        <img class='posterMovie' src='./public/image/{$film['affiche_film']}'>"
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
    while ($actor = $actorsRole->fetch()) {
        echo "<figure class='figure_actor'>
        <img class='posterMovie' src='./public/image/{$actor["photo"]}'>"
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