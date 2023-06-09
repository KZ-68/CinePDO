<?php
ob_start();
// démarre la temporisation de sortie
?>

<section class="section_addFilms">

<h2 id='h2_addFilms'>Ajout Film</h2>

    <div class="addFilms_wrapper">
        <form class='formular_base' action="" method="post">
            <div class="titre">
                <label for="titre">Titre :</label>
                <input type="text" name="titre" id="titre" required>
            </div>
            <div class="date_sortie">
                <label for="date_sortie_france">Date de sortie en France :</label>
                <input type="text" name="date_sortie_france" id="date_sortie_france" required>
            </div>
            <div class="duree">
                <label for="duree">Durée :</label>
                <input type="number" name="duree" id="duree" placeholder="minutes" required>
            </div>
            <div class="note">
                <label for="note">Note :</label>
                <input type="number" step="0.1" name="note" id="note" required>
            </div>
            <div class="genre">
                <label for="id_genre">Genre :</label>
                <select name="id_genre" id="genre_film" required>
                <?php
                    // Récupére et sélectionn la liste des genres depuis ma base de données
                    $dao = new DAO();
                    $sql = "SELECT g.id_genre, g.libelle
                            FROM genre g";
                    $result = $dao->executerRequete($sql);
                    
                    // Parcouree les colonnes et affiche les options de la liste déroulante
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $idgenre = $row['id_genre'];
                        $libelle = $row['libelle'];
                        echo "<option value='$idgenre'>$libelle</option>";
                    }
                ?>
                </select>
            </div>
            <label for="id_realisateur">Réalisateur :</label>
            <select name="id_realisateur" id="id_realisateur" required>
            <?php
                // Récupérez la liste des réalisateurs depuis votre base de données
                $dao = new DAO();
                $sql = "SELECT re.id_realisateur, p.nom, p.prenom 
                        FROM realisateur re
                        INNER JOIN personne p ON re.id_personne = p.id_personne";
                $result = $dao->executerRequete($sql);
                
                // Parcourez les résultats et affichez les options de la liste déroulante
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $idRealisateur = $row['id_realisateur'];
                    $prenomRealisateur = $row['prenom'];
                    $nomRealisateur = $row['nom'];
                    echo "<option value='$idRealisateur'>$prenomRealisateur $nomRealisateur</option>";
                }
                ?>
            </select>

            <label for="affiche_film">Affiche :</label>
            <input type="file" name="affiche_film" id="affiche_film">
            
            <label for="synopsis">Synopsis :</label>
            <textarea name="synopsis" id="synopsis" rows="4" required></textarea>

            <input id="submit" type="submit" name="addFilm" value="Ajouter">
        </form>
    </div>

</section>

<?php

$title = "Ajout d'un film ";
$content = ob_get_clean();
require "views/template.php"
?>