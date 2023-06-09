<?php
ob_start();
// démarre la temporisation de sortie
?>

<section class="section_appartenir">

<h2 id='h2_appartenir'>Ajout d'un genre appartenant à un film</h2>

    <div class="appartenir_wrapper">
        <form class='formular_base' action="" method="post">
            <div class="film">
                <label for="id_film">Film :</label>
                <select name="id_film" id="id_film" required>
                <?php
                    $dao = new DAO();
                    $sql = "SELECT f.id_film, f.titre
                            FROM film f";
                    $result = $dao->executerRequete($sql);
                    
                    while ($row = $result->fetch()) {
                        $idFilm = $row['id_film'];
                        $titre = $row['titre'];
                        echo "<option value='$idFilm'>$titre</option>";
                    }
                ?>
                </select>
            </div>
            <div class="genre">
                <label for="id_genre">Genre :</label>
                <select name="id_genre" id="id_genre" required>
                <?php
                    // Récupérer et sélectionner la liste des genres depuis ma base de données
                    $dao2 = new DAO();
                    $sql2 = "SELECT g.id_genre, g.libelle
                            FROM genre g";
                    $result2 = $dao2->executerRequete($sql2);
                    
                    // Parcourir les colonnes et afficher les options de la liste déroulante
                    while ($row2 = $result2->fetch()) {
                        $idgenre = $row2['id_genre'];
                        $libelle = $row2['libelle'];
                        echo "<option value='$idgenre'>$libelle</option>";
                    }
                ?>
                </select>
            </div>

            <input id="submit" type="submit" name="appartenir" value="Ajouter">
        </form>
    </div>

</section>

<?php

$title = "Ajout d'un genre appartenant à un film ";
$content = ob_get_clean();
require "views/template.php"
?>