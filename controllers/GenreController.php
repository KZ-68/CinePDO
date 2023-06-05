<?php

class GenreController{

    public function findAllGenres()  {

        $dao = new DAO();

        $sql = "SELECT
                    g.id_genre,
                    g.libelle
                FROM genre g";

        $genres = $dao->executerRequete($sql);

        require "views/genre/listGenres.php";
    }
}

?>