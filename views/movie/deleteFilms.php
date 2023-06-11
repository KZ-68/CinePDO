<?php
ob_start();
// démarre la temporisation de sortie
?>

<form class='formular_base' action="" method="post">
    
    <label for="id_film">Réalisateur :</label>
    <select name="id_film" id="id_film" required>
    <?php
        // Récupérer la liste des réalisateurs depuis ma base de données
        $dao = new DAO();
        $sql = "SELECT f.id_film, f.titre, f.date_sortie_france, f.duree, f.synopsis, f.note, affiche_film, f.id_realisateur
                FROM film f";
        $result = $dao->executerRequete($sql);
        
        // Parcourir les résultats et afficher les options de la liste déroulante
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $idFilm = $row['id_film'];
            $titre = $row['titre'];
            $dateSortie = $row['date_sortie_france'];
            $duree = $row['duree'];
            $synopsis = $row['synopsis'];
            $note = $row['note'];
            $afficheFilm = $row['affiche_film'];
            $idRealisateur = $row['id_realisateur'];
            echo "<option value='$idFilm'>$titre</option>";
        }
        ?>
    </select>

    <input id="submit" type="submit" name="removeFilm" value="Supprimer">
</form>

<?php

$title = "Supprimer un film";
$content = ob_get_clean();
require "views/template.php";
?>