<?php

require_once "bdd/DAO.php";

class MovieController{

    public function findAllFilms()  {

        $dao = new DAO();

        $sql = "SELECT
                    f.id_film,
                    f.titre,
                    f.affiche_film,
                    DATE_FORMAT(f.date_sortie_france, '%e %M %Y') AS sortieSalleFrance,
                    SEC_TO_TIME(f.duree*60) AS tempsHeure,
                    f.note,
                    f.synopsis
                FROM film f
                GROUP BY 
                    f.id_film,
                    f.titre,
                    f.affiche_film,
                    sortieSalleFrance,
                    f.note,
                    f.synopsis
                ORDER BY tempsHeure";

        $films = $dao->executerRequete($sql);

        require "views/movie/listFilms.php";
    }

}

?> 