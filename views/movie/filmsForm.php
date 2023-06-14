<?php
ob_start();
// démarre la temporisation de sortie
?>

<section class="section_filmsForm">

<h2 id='h2_filmsForm'>Ajout Film</h2>

    <div class="filmsForm_wrapper">
        <form class='formular_base' action="index.php?action=addFilms" method="post">
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
            
            <label for="id_realisateur">Réalisateur :</label>
            <select name="id_realisateur" id="id_realisateur" required>
            <?php
            while ($director = $filmDirector->fetch(PDO::FETCH_ASSOC)) {
                    $idRealisateur = $director['id_realisateur'];
                    $prenomRealisateur = $director['prenom'];
                    $nomRealisateur = $director['nom'];
                    echo "<option value='$idRealisateur'>$prenomRealisateur $nomRealisateur</option>";
            }
            ?>
            </select>

            <!-- Pour que l'array soit bien pris en compte dans la boucle, les symboles [] doivent se trouver devant le name du <select> -->
            <select name="id_genre[]" id="id_genre" multiple required>
            <?php
            while ($genre = $filmGenres->fetch()) {
                    echo "<option value=".$genre['id_genre'].">".$genre['libelle']."</option>";
            }
            ?>
            </select>

            <input id="affiche_film" name="affiche_film" type="file"/>

            <label for="synopsis">Synopsis :</label>
            <textarea name="synopsis" id="synopsis" rows="4" required></textarea>

            <input id="submit" type="submit" name="addFilms" value="Ajouter">
        </form>
    </div>

</section>

<?php

$title = "Ajout d'un film ";
$content = ob_get_clean();
require "views/template.php"
?>