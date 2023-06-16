<?php
ob_start();
// démarre la temporisation de sortie
?>

<section class="section_addCastings">

<h2 id='h2_addCastings'>Ajout Casting</h2>

    <div class="addCastings_wrapper">
    
    <form action ='' method='post'>

    <select name = "id_acteur" id="id_acteur" required>

        <option value = "" selected>Nom acteur</option> 

        <?php while ($acteur = $actorCasting->fetch()){ 
        
            echo "<option value = ".$acteur['id_acteur'].">".$acteur['prenom']." ".$acteur['nom']."</option>";

        }?>  

    </select>

    <select name = "id_role" id="id_role" required>
        
    <option value = "" selected>Nom acteur</option> 

        <?php while ($role = $roleCasting->fetch()){ 

            echo "<option value = ".$role['id_role'].">".$role['nom_role']." ".$role['nom']."</option>";

        }?>       

    </select>

            <input id="submit" type="submit" name="addCasting" value="Ajouter">
        </form>
    </div>

</section>

<?php

$title = "Ajout d'un casting";
$content = ob_get_clean();
require "views/template.php"
?>