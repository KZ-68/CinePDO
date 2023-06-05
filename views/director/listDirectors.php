<?php
ob_start();
// démarre la temporisation de sortie
?>


<h2>Liste des réalisateurs</h2>

<?= $directors->rowcount() ?>

<?php
while ($director = $directors->fetch()) {

    echo "<p>Prénom du Réalisateur : {$director["prenom"]}</p>";

    echo "<p>Nom du Réalisateur : {$director["nom"]}</p>";

    echo "<p>Sexe : {$director["sexe"]}</p>";

    echo "<p>Date de naissance : {$director["date_naissance"]}</p>";

?>
    <a href="index.php?action=detailRealisateur&id=<?=$director['id_realisateur']?>">Detail Réalisateur</a>
<?php
}

?>

<?php

$title = "Liste des réalisateurs "; 
$content = ob_get_clean();
require "views/template.php"
?>