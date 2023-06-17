<?php
ob_start();
// démarre la temporisation de sortie
?>

<section class="section_updateFilms">

<h2 id='h2_updateFilms'>Modifier un Film</h2>

    <div class="updateFilms_wrapper">
        <form class='formular_base' action="" method="post">
            <div class="titre">
                <label for="titre">Titre :</label>
                <input type="text" name="titre" id="titre" required>
            </div>
            <div class="date_sortie">
                <label for="date_sortie_france">Date de sortie en France :</label>
                <input type="date" name="date_sortie_france" id="date_sortie_france" required>
            </div>
            <div class="duree">
                <label for="duree">Durée :</label>
                <input type="number" name="duree" id="duree" placeholder="minutes" required>
            </div>
            <div class="note">
                <label for="note">Note :</label>
                <input type="number" step="0.1" name="note" id="note" required>
            </div>
            <div class="realisateur">
            <label for="id_realisateur">Réalisateur :</label>
            <select name="id_realisateur" id="id_realisateur" required>
            <?php
                // Récupérer la liste des réalisateurs depuis ma base de données
                $dao = new DAO();
                $sql = "SELECT re.id_realisateur, p.nom, p.prenom 
                        FROM realisateur re
                        INNER JOIN personne p ON re.id_personne = p.id_personne";
                $result = $dao->executerRequete($sql);
                
                // Parcourir les résultats et afficher les options de la liste déroulante
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $idRealisateur = $row['id_realisateur'];
                    $prenomRealisateur = $row['prenom'];
                    $nomRealisateur = $row['nom'];
                    echo "<option value='$idRealisateur'>$prenomRealisateur $nomRealisateur</option>";
                }
                ?>
            </select>
            </div>

            <label for="affiche_film">Affiche :</label>
            <input type="file" name="affiche_film" id="affiche_film">
            
            <label for="synopsis">Synopsis :</label>
            <textarea name="synopsis" id="synopsis" rows="4" required></textarea>

            <?php
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $idFilm = $row['id_film'];
            echo "<input type='hidden' name='id' value='$idFilm'>";
            }
            ?>

            <input id="submit" type="submit" name="updateFilm" value="Ajouter">
        </form>
    </div>

</section>

<?php

$title = "Modifier un film ";
$content = ob_get_clean();
require "views/template.php"
?>