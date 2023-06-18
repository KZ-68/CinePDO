<?php
ob_start();
// démarre la temporisation de sortie
?>

<section class="section_deleteCastings">

<h2 id='h2_deleteCastings'>Supprimer Casting</h2>

    <div class="deleteCastings_wrapper">
    
    <form class='formular_base' action ='' method='post'>

    <select name = "id_acteur" id="id_acteur" required>

        <option value = "" selected>Nom acteur</option> 

        <?php 
        while ($acteur = $actorCasting->fetch()){ 
        
            echo "<option value = ".$acteur['id_acteur'].">".$acteur['prenom']." ".$acteur['nom']."</option>";

        }
        ?>  

    </select>

    <select name = "id_role" id="id_role" required>
        
    <option value = "" selected>Nom du role</option> 

        <?php while ($role = $roleCasting->fetch()){ 

            echo "<option value = ".$role['id_role'].">".$role['nom_role']." ".$role['nom']."</option>";

        }?>       

    </select>

            <input id="submit" type="submit" name="deleteCasting" value="Supprimer">
        </form>
    </div>

</section>

<?php

$title = "Supprimer un casting";
$content = ob_get_clean();
require "views/template.php"
?>