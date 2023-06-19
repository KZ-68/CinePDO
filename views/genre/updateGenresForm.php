<?php
ob_start();
// démarre la temporisation de sortie
?>

<section class="section_updateGenres">

<h2 id='h2_updateGenres'>Editer Genre</h2>

    <div class="updateGenres_wrapper">
        <?php
        if ($genre = $idGenre->fetch()) {
        ?>
            <form class='formular_base' action="index.php?action=updateGenres&id=<?=$genre['id_genre']?>" method="post">
                <div class="libelle">
                    <label for="libelle">Libellé du Genre :</label>
                    <input type="text" name="libelle" id="libelle" required>
                </div>
                <input id="submit" type="submit" name="updateGenre" value="Ajouter">
            </form>
        <?php 
        }
        ?> 
    </div>

</section>

<?php

$title = "Mise à jour d'un genre";
$content = ob_get_clean();
require "views/template.php"
?>