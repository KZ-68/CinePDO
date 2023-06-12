<?php
ob_start();
// démarre la temporisation de sortie
?>

<form class='formular_base' action="" method="post">
    
    <label for="id_genre">Supprimer un genre :</label>
    <select name="id_genre" id="id_genre" required>
    <?php
        // Récupérer la liste des réalisateurs depuis ma base de données
        $dao = new DAO();
        $sql = "SELECT g.id_genre, g.libelle
                FROM genre g";
        $result = $dao->executerRequete($sql);
        
        // Parcourir les résultats et afficher les options de la liste déroulante
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $idGenre = $row['id_genre'];
            $libelle = $row['libelle'];
            echo "<option value='$idGenre'>$libelle</option>";
        }
        ?>
    </select>

    <input id="submit" type="submit" name="deleteGenre" value="Supprimer">
</form>

<?php

$title = "Supprimer un genre";
$content = ob_get_clean();
require "views/template.php";
?>