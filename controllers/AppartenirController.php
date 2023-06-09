<?php

require_once "bdd/DAO.php";

class AppartenirController{

    public function addAppartenir()  {

        $dao = new DAO();

        if (isset($_POST['addAppartenir'])) {

        $idFilm = $_POST['id_film'];
        $idgenre = $_POST['id_genre'];

        $sql = "INSERT INTO appartenir (id_film, id_genre) VALUES (:id_film, :id_genre)";
        $params = [
                ":id_film" => $idFilm,
                ":id_genre" => $idgenre
                ];
        $addAppartenir = $dao->executerRequete($sql, $params);
        
        }
        require "views/appartenir/appartenir.php";
    }
    

}

?>