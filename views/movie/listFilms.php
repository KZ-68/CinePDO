<?php
ob_start();
// démarre la temporisation de sortie
?>


<h2>Liste des films</h2>


<?= "<p>{$films->rowcount()}</p>" ?>

<?php
while ($film = $films->fetch()) {

    echo "<div class='card_website'>
    <p>{$film["id_film"]}</p>";
?>
    
<a href="index.php?action=detailFilm&id=<?=$film['id_film']?>">
    <!-- <p>Detail Film</p> -->
    <h3><?= $film["titre"] ?></h3>
</a>

<?php
    echo "{$film["affiche_film"]}";
?>
  </div>  
<?php
}

?>

<?php
$title = "Liste des films "; 
$content = ob_get_clean();
require "views/template.php"
?>