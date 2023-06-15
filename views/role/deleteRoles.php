<?php
ob_start();
// démarre la temporisation de sortie
?>

<form class='formular_base' action="" method="post">
    
    <label for="id_role">Supprimer un role :</label>
    <select name="id_role" id="id_role" required>
    <?php
        // Parcourir les résultats et afficher les options de la liste déroulante
        while ($row = $roles->fetch(PDO::FETCH_ASSOC)) {
            $idRole = $row['id_role'];
            $nomRole = $row['nom_role'];
            echo "<option value='$idRole'>$nomRole</option>";
        }
        ?>
    </select>

    <input id="submit" type="submit" name="deleteRole" value="Supprimer">
</form>

<?php

$title = "Supprimer un rôle";
$content = ob_get_clean();
require "views/template.php";
?>