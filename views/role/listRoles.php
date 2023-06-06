<?php
ob_start();
// démarre la temporisation de sortie
?>


<h2>Liste des roles</h2>

<?= "{$roles->rowcount()}\n" ?>

<?php
while ($role = $roles->fetch()) {

    echo "{$role["id_role"]}\n";

    echo "Nom du Personnage : {$role["nom_role"]}\n";

?>
    <p><a href="index.php?action=detailRole&id=<?=$role['id_role']?>">Detail Role</a></p>
<?php
}

?>

<?php

$title = "Liste des roles "; 
$content = ob_get_clean();
require "views/template.php"
?>