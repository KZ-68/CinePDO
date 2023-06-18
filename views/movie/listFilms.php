<?php
ob_start();
// démarre la temporisation de sortie
?>


<h2>Liste des films</h2>


<?= "<p>Nombre de films dans la base de données : {$films->rowcount()}</p>" ?>

<a class='links' href='index.php?action=deleteFilms'>
    <p class='films_btn'>Supprimer Film</p>
</a>

<a class='links' href='index.php?action=filmsForm'>
    <p class='films_btn'>Ajouter Films
    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-square' viewBox='0 0 16 16'>
        <path d='M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z'/>
        <path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/>
    </svg>
    </p>
</a>

<?php
while ($film = $films->fetch()) {

    echo "<div class='card_website'>
    <p>{$film["id_film"]}</p>";
?>

<a class='links' href='index.php?action=addCastings&id=<?=$film['id_film']?>'>
    <p class='films_btn'>Ajouter casting</p>
</a>

<a class='links' href='index.php?action=deleteCastings&id=<?=$film['id_film']?>'>
    <p class='films_btn'>Supprimer casting</p>
</a>

<a class='links' href="index.php?action=detailFilm&id=<?=$film['id_film']?>">
    <!-- <p>Detail Film</p> -->
    <h3><?= $film["titre"] ?></h3>
</a>

<?php
    echo "<img class='posterMovie' src='./public/image/{$film['affiche_film']}'>";
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