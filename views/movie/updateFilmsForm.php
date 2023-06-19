<?php
ob_start();
// démarre la temporisation de sortie
?>

<section class="section_updateFilms">

<h2 id='h2_updateFilms'>Modifier un Film</h2>

    <div class="updateFilms_wrapper">
        <?php
        if ($film = $idFilmsForm->fetch()) {
        ?>
            <form class='formular_base' action="index.php?action=updateFilms&id=<?=$film['id_film']?>" method="post">
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
                    // Parcourir les résultats et afficher les options de la liste déroulante
                    while ($row = $filmDirector->fetch(PDO::FETCH_ASSOC)) {
                        $idRealisateur = $row['id_realisateur'];
                        $prenomRealisateur = $row['prenom'];
                        $nomRealisateur = $row['nom'];
                        echo "<option value='$idRealisateur'>$prenomRealisateur $nomRealisateur</option>";
                    }
                    ?>
                </select>
                </div>

                <select name="id_genre[]" id="id_genre" multiple required>
                <?php
                while ($genre = $filmGenresForm->fetch()) {
                        echo "<option value=".$genre['id_genre'].">".$genre['libelle']."</option>";
                }
                ?>
                </select>

                <label for="affiche_film">Affiche :</label>
                <input type="file" name="affiche_film" id="affiche_film">
                
                <label for="synopsis">Synopsis :</label>
                <textarea name="synopsis" id="synopsis" rows="4" required></textarea>

                <input id="submit" type="submit" name="updateFilm" value="Ajouter">
            </form>
        <?php
        }
        ?>
    </div>

</section>

<?php

$title = "Modifier un film ";
$content = ob_get_clean();
require "views/template.php"
?>