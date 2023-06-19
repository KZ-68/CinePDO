<?php
ob_start();
// démarre la temporisation de sortie
?>


<h2>Liste des acteurs</h2>

<?= "<p>Nombre d'acteurs dans la base de données : {$actors->rowcount()}</p>" ?>

<a class='links' href='index.php?action=deleteActorsForm'>
<p class='actors_btn'>Supprimer Acteur</p>
</a>

<a class='links' href='index.php?action=addActorsForm'>
    <p class='actors_btn'>Ajouter Acteurs
    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-square' viewBox='0 0 16 16'>
        <path d='M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z'/>
        <path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/>
    </svg>
    </p>
</a>

<?php
while ($actor = $actors->fetch()) {

    echo "<div class='card_website'>
    <p>{$actor["id_acteur"]}</p>
    <p>{$actor["prenom"]} {$actor["nom"]}</p>
    ";
?>
    <a class='links' href="index.php?action=detailActor&id=<?=$actor['id_acteur']?>">
        <p class='actors_btn'>Detail Acteur</p>
    </a>
    </div>
<?php
}

?>

<?php

$title = "Liste des acteurs "; 
$content = ob_get_clean();
require "views/template.php"
?>