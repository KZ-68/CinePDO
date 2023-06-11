<?php
ob_start();
// démarre la temporisation de sortie
?>

<section class="section_addDirectors">

<h2 id='h2_addDirectors'>Ajout Réalisateur</h2>

    <div class="addDirectors_wrapper">
        <form class='formular_base' action="" method="post">
            <label for="id_personne">Personne :</label>
            <select name="id_personne" id="id_personne" required>
            <?php

                $dao = new DAO();
                $sql = "SELECT p.id_personne, p.nom, p.prenom 
                        FROM personne p";
                $result = $dao->executerRequete($sql);
                
                // Parcourir les résultats et afficher les options de la liste déroulante
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $idPersonne = $row['id_personne'];
                    $prenom = $row['prenom'];
                    $nom = $row['nom'];
                    echo "<option value='$idPersonne'>$prenom $nom</option>";
                }
                ?>
            </select>

            <input id="submit" type="submit" name="addDirector" value="Ajouter">
        </form>
    </div>

</section>

<?php

$title = "Ajout d'un réalisateur ";
$content = ob_get_clean();
require "views/template.php"
?>