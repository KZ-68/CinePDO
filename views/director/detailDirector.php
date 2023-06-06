<?php
ob_start();
// démarre la temporisation de sortie
?>

<?php
if ($director = $director->fetch()) {

    echo "<div class='card_website'>
        Prénom et Nom de l'acteur : {$director["prenom"]}{$director["nom"]}<br/>
        Sexe : {$director["sexe"]}<br/>
        Date de naissance : {$director["date_naissance"]}</p>
    </div>";
}
?>

<?php
 
$content = ob_get_clean();
require "views/template.php"
?>
