<?php
ob_start();
// démarre la temporisation de sortie
?>

<?php
if ($director = $director->fetch()) {

    echo "<div class='card_website'>
    <a href='index.php?action=updateDirectorsForm&id={$director['id_personne']}'>
    <h3>Modifier ce réalisateur</h3>
    </a></p>
    <img class='photoPerson' src='public/image/{$director["photo"]}'<br/>
        <p>Prénom et Nom de l'acteur : {$director["prenom"]} {$director["nom"]}<br/>
        Sexe : {$director["sexe"]}<br/>
        Date de naissance : {$director["date_naissance"]}</p>
    </div>";
?>
<h4>Filmographie du réalisateur</h4>
<section class="section_director1">
<?php  
    while ($director = $directorFilms->fetch()) {
            echo "<figure class='figure_film'>
            <img class='posterMovie' src='./public/image/{$director['affiche_film']}'>"
        ?>
            <a class='link_film' href='index.php?action=detailFilm&id=<?=$director['id_film']?>'>
            <h5><?=$director['titre']?></h5></a>
        <?php
            echo "</figcaption>
            </figure>";
    }
}
?>
</section>

<?php
 
$title = "Détails du réalisateur ";
$content = ob_get_clean();
require "views/template.php"
?>
