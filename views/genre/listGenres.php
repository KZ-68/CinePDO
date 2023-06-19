<?php
ob_start();
// démarre la temporisation de sortie
?>


<h2>Liste des genres</h2>

<?= "Nombre de genres dans la base de données : {$genres->rowcount()}\n" ?>

<a class='links' href='index.php?action=deleteGenresForm'>
<p class='genres_btn'>Supprimer Genre</p>
</a>

<a class='links' href='index.php?action=genresForm'>
        <p class='genres_btn'>Ajouter Genres
        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-square' viewBox='0 0 16 16'>
            <path d='M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z'/>
            <path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/>
        </svg>
        </p>
    </a>

<?php
while ($genre = $genres->fetch()) {

    echo "{$genre["id_genre"]}\n";

    echo "Libellé du genre : {$genre["libelle"]}\n";

?>
    <a class='links' href="index.php?action=detailGenre&id=<?=$genre['id_genre']?>">
        <p class='genres_btn'>Detail Genre</p>
    </a>
<?php
}

?>

<?php

$title = "Liste des genres "; 
$content = ob_get_clean();
require "views/template.php"
?>