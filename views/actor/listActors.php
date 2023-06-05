<?php
ob_start();
// démarre la temporisation de sortie
?>


<h2>Liste des acteurs</h2>

<?= $actors->rowcount() ?>

<?php
while ($actor = $actors->fetch()) {

    echo "<p>Prénom de l'acteur : {$actor["prenom"]}</p>";

    echo "<p>Nom de l'acteur : {$actor["nom"]}</p>";

    echo "<p>Sexe : {$actor["sexe"]}</p>";

    echo "<p>Date de naissance : {$actor["date_naissance"]}</p>";

?>
    <a href="index.php?action=detailActeur&id=<?=$actor['id_acteur']?>">Detail Acteur</a>
<?php
}

?>

<?php

$title = "Liste des acteurs "; 
$content = ob_get_clean();
require "views/template.php"
?>