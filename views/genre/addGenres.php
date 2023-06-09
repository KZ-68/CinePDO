<?php
ob_start();
// démarre la temporisation de sortie
?>

<section class="section_addGenres">

<h2 id='h2_addGenres'>Ajout Genre</h2>

    <div class="addGenres_wrapper">
        <form class='formular_base' action="" method="post">
            <div class="libelle">
                <label for="libelle">Libellé du Genre :</label>
                <input type="text" name="libelle" id="libelle" required>
            </div>
            <input id="submit" type="submit" name="addGenre" value="Ajouter">
        </form>
    </div>

</section>

<?php

$title = "Ajout d'un genre";
$content = ob_get_clean();
require "views/template.php"
?>