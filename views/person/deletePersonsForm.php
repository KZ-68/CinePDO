<?php
ob_start();
// démarre la temporisation de sortie
?>

<form class='formular_base' action="index.php?action=deletePersons" method="post">
    
    <label for="id_personne">Supprimer une personne:</label>
    <select name="id_personne" id="id_personne" required>
    <?php
        // Parcourir les résultats et afficher les options de la liste déroulante
        while ($row = $person->fetch()) {
        ?>
            <option value='<?=$row['id_personne']?>'><?=$row['prenom']?> <?=$row['nom']?></option>;
        <?php
        }
        ?>
    </select>

    <input id="submit" type="submit" name="deletePerson" value="Supprimer">
</form>

<?php

$title = "Supprimer d'une personne";
$content = ob_get_clean();
require "views/template.php";
?>