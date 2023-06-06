<?php
ob_start();
// démarre la temporisation de sortie
?>


<h2>Liste des réalisateurs</h2>

<?= "<p>{$directors->rowcount()}</p>" ?>

<?php
while ($director = $directors->fetch()) {

    echo "<div class='card_website'>
        <p>{$director["id_realisateur"]}<br/>
        {$director["prenom"]} {$director["nom"]}</p>";

?>
    <p><a href="index.php?action=detailDirector&id=<?=$director['id_realisateur']?>">Detail Réalisateur</a></p>
    </div>
<?php
}

?>

<?php

$title = "Liste des réalisateurs "; 
$content = ob_get_clean();
require "views/template.php"
?>