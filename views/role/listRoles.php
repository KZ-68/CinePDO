<?php
ob_start();
// démarre la temporisation de sortie
?>


<h2>Liste des roles</h2>

<?= $roles->rowcount() ?>

<?php
while ($role = $roles->fetch()) {

    echo "<p>{$role["id_role"]}</p>";

    echo "<p>Nom du Personnage : {$role["nom_role"]}</p>";

?>
    <a href="index.php?action=detailRole&id=<?=$role['id_role']?>">Detail Role</a>
<?php
}

?>

<?php

$title = "Liste des roles "; 
$content = ob_get_clean();
require "views/template.php"
?>