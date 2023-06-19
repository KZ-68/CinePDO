<?php
ob_start();
// démarre la temporisation de sortie
?>

<section class="section_addActors">

<h2 id='h2_addActors'>Ajout Acteur</h2>

    <div class="addActors_wrapper">
        <form class='formular_base' action="index.php?action=addActors" method="post">
            <label for="id_personne">Personne :</label>
            <select name="id_personne" id="id_personne" required>
            <?php
            
                // Parcourir les résultats et afficher les options de la liste déroulante
                while ($row = $person->fetch(PDO::FETCH_ASSOC)) {
                    $idPersonne = $row['id_personne'];
                    $prenom = $row['prenom'];
                    $nom = $row['nom'];
                    echo "<option value='$idPersonne'>$prenom $nom</option>";
                }
                ?>
            </select>

            <input id="submit" type="submit" name="addActor" value="Ajouter">
        </form>
    </div>

</section>

<?php

$title = "Ajout d'un acteur";
$content = ob_get_clean();
require "views/template.php"
?>