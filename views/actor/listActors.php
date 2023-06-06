<?php
ob_start();
// démarre la temporisation de sortie
?>


<h2>Liste des acteurs</h2>

<?= "<p>{$actors->rowcount()}</p>" ?>

<?php
while ($actor = $actors->fetch()) {

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

<?php

$title = "Liste des acteurs "; 
$content = ob_get_clean();
require "views/template.php"
?>