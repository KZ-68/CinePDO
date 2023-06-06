<?php
ob_start();
// démarre la temporisation de sortie
?>


<h2>Liste des genres</h2>

<?= "{$genres->rowcount()}\n" ?>

<?php
while ($genre = $genres->fetch()) {

    echo "{$genre["id_genre"]}\n";

    echo "Libellé du genre : {$genre["libelle"]}\n";

?>
    <p><a href="index.php?action=detailGenre&id=<?=$genre['id_genre']?>">Detail Genre</a></p>
<?php
}

?>

<?php

$title = "Liste des genres "; 
$content = ob_get_clean();
require "views/template.php"
?>