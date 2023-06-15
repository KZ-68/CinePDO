<?php
ob_start();
// démarre la temporisation de sortie
?>

<form class='formular_base' action="" method="post">
    
    <label for="id_acteur">Supprimer un Acteur :</label>
    <select name="id_acteur" id="id_acteur" required>
    <?php
        // Parcourir les résultats et afficher les options de la liste déroulante
        while ($row = $actor->fetch(PDO::FETCH_ASSOC)) {
            $idActeur = $row['id_acteur'];
            $prenomActeur = $row['prenom'];
            $nomActeur = $row['nom'];
            echo "<option value='$idActeur'>$prenomActeur $nomActeur</option>";
        }
        ?>
    </select>

    <input id="submit" type="submit" name="deleteActor" value="Supprimer">
</form>

<?php

$title = "Supprimer un Acteur";
$content = ob_get_clean();
require "views/template.php";
?>