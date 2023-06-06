<?php
ob_start();
// démarre la temporisation de sortie
?>

<?php
if ($actor = $actor->fetch()) {

    echo "<div class='card_website'>
        Prénom et Nom de l'acteur : {$actor["prenom"]}{$actor["nom"]}<br/>
        Sexe : {$actor["sexe"]}<br/>
        Date de naissance : {$actor["date_naissance"]}</p>
    </div>";
}
?>

<?php
 
$content = ob_get_clean();
require "views/template.php"
?>