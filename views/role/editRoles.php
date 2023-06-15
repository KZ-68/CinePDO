<?php
ob_start();
// démarre la temporisation de sortie
?>

<section class="section_editRoles">

<h2 id='h2_editRoles'>Editer un role</h2>

    <div class="editRoles_wrapper">
        <form class='formular_base' action="" method="post">
            <div class="nom_role">
                <label for="nom_role">Nom du role:</label>
                <input type="text" name="nom_role" id="nom_role" required>
            </div>

            <input id="submit" type="submit" name="editRoleCasting" value="Editer">
        </form>
    </div>

</section>

<?php

$title = "Editer un role";
$content = ob_get_clean();
require "views/template.php"
?>