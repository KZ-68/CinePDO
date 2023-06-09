<?php
ob_start();
// démarre la temporisation de sortie
?>


<h2>Liste des Personnes</h2>

<a class='links' href='index.php?action=deletePersonsForm'>
<p class='persons_btn'>Supprimer Personne</p>
</a>

<a class='addPersons_link' href='index.php?action=personsForm'>
    <p class='addPersons_btn'>Ajouter Personnes
    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-square' viewBox='0 0 16 16'>
        <path d='M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z'/>
        <path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/>
    </svg>
    </p>
</a>

<section>
<h3>Les acteurs</h3>
<?php
while ($actor = $personActors->fetch()) {

    echo "<div class='card_website'>
    <p>{$actor["id_acteur"]}</p>
    <p>{$actor["prenom"]} {$actor["nom"]}</p>
    ";
?>
    <a href="index.php?action=detailActor&id=<?=$actor['id_acteur']?>">
        <p>Detail Acteur</p>
    </a>
    </div>
<?php
}

?>
</section>

<section>
<h3>Les réalisateurs</h3>
<?php
while ($director = $personDirectors->fetch()) {

    echo "<div class='card_website'>
    <p>{$director["id_realisateur"]}</p>
    <p>{$director["prenom"]} {$director["nom"]}</p>
    ";
?>
    <a href="index.php?action=detailDirector&id=<?=$director['id_realisateur']?>">
        <p>Detail Acteur</p>
    </a>
    </div>
<?php
}

?>
</section>

<?php
$title = "Liste des personnes "; 
$content = ob_get_clean();
require "views/template.php"
?>