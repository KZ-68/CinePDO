<?php
ob_start();
// démarre la temporisation de sortie
?>

<form class='formular_base' action="" method="post">
    
    <label for="id_realisateur">Supprimer un realisateur :</label>
    <select name="id_realisateur" id="id_realisateur" required>
    <?php
        // Parcourir les résultats et afficher les options de la liste déroulante
        while ($row = $director->fetch(PDO::FETCH_ASSOC)) {
            $idRealisateur = $row['id_realisateur'];
            $prenomRealisateur = $row['prenom'];
            $nomRealisateur = $row['nom'];
            echo "<option value='$idRealisateur'>$prenomRealisateur $nomRealisateur</option>";
        }
        ?>
    </select>

    <input id="submit" type="submit" name="deleteDirector" value="Supprimer">
</form>

<?php

$title = "Supprimer un Réalisateur";
$content = ob_get_clean();
require "views/template.php";
?>