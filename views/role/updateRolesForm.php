<?php
ob_start();
// démarre la temporisation de sortie
?>

<section class="section_updateRoles">

<h2 id='h2_updateRoles'>Editer un role</h2>

    <div class="updateRoles_wrapper">
        <?php
        if ($role = $idRoleForm->fetch()) {
        ?>
            <form class='formular_base' action="index.php?action=updateRoles&id=<?=$role['id_role']?>" method="post">
            <div class="nom_role">
                <label for="nom_role">Nom du role:</label>
                <input type="text" name="nom_role" id="nom_role" required>
            </div>

            <input id="submit" type="submit" name="updateRole" value="Editer">
            </form>
        <?php
        }
        ?>
    </div>

</section>

<?php

$title = "Editer un role";
$content = ob_get_clean();
require "views/template.php"
?>