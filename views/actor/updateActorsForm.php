<?php
ob_start();
// démarre la temporisation de sortie
?>

<section class="section_updateActors">

<h2 id='h2_updateActors'>Editer Acteur</h2>

    <div class="updateActors_wrapper">
        <?php
        if ($actor = $idPersonsForm->fetch()){
        ?>
            <form class='formular_base' action="index.php?action=updateActors&id=<?=$actor['id_personne']?>" method="post">
                
                <label for="photo">Photo :</label>
                <input type="file" name="photo" id="photo">
            
                <div class="prenom">
                    <label for="prenom">Prénom :</label>
                    <input type="text" name="prenom" id="prenom" required>
                </div>

                <div class="nom">
                    <label for="nom">Nom :</label>
                    <input type="text" name="nom" id="nom" required>
                </div>
                <div class="sexe">
                    <label for="duree">Sexe :</label>
                    <input type="text" name="sexe" id="sexe" required>
                </div>
                <div class="date_naissance">
                    <label for="date_naissance">Note :</label>
                    <input type="date" id="date_naissance" name="date_naissance" value="date_naissance" required>
                </div>

                <input id="submit" type="submit" name="updateActor" value="Editer">
            </form>
        <?php
        }
        ?>
    </div>

</section>

<?php

$title = "Ajout d'une Personne ";
$content = ob_get_clean();
require "views/template.php"
?>