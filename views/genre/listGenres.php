<?php
ob_start();
// démarre la temporisation de sortie
?>


<h2>Liste des genres</h2>

<?= $genres->rowcount() ?>

<?php
while ($genre = $genres->fetch()) {

    echo "<p>{$genre["id_genre"]}</p>";

    echo "<p>Libellé du genre : {$genre["libelle"]}</p>";

?>
    <a href="index.php?action=detailGenre&id=<?=$genre['id_genre']?>">Detail Genre</a>
<?php
}

?>

<?php

$title = "Liste des genres "; 
$content = ob_get_clean();
require "views/template.php"
?>