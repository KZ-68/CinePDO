<?php
ob_start();
// démarre la temporisation de sortie
?>

<section class="section_addRoles">

<h2 id='h2_addRoles'>Ajout Rôle</h2>

    <div class="addRoles_wrapper">
        <form class='formular_base' action="index.php?action=addRoles" method="post">
            <div class="nom_role">
                <label for="nom_role">Nom du Role :</label>
                <input type="text" name="nom_role" id="nom_role" required>
            </div>
            <input id="submit" type="submit" name="addRole" value="Ajouter">
        </form>
    </div>

</section>

<?php

$title = "Ajout d'un Rôle";
$content = ob_get_clean();
require "views/template.php"
?>