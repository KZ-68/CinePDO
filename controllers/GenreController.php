<?php

require_once "bdd/DAO.php";

class GenreController{

    private static $instance = null;

    public static function getInstance() {
        if (self::$instance) {
            return self::$instance;
        } else {
            self::$instance = new GenreController();
            return self::$instance;
        }
    }

    public function findAllGenres()  {

        $dao = new DAO();

        $sql = "SELECT
                g.id_genre,
                g.libelle
                FROM
                genre g";

        $genres = $dao->executerRequete($sql);

        require "views/genre/listGenres.php";
    }

    public function findOneGenre($id)  {

        $dao = new DAO();

        $sql = "SELECT
                    g.id_genre,
                    g.libelle,
                    f.titre,
                    DATE_FORMAT(f.date_sortie_france, '%e %M %Y') AS sortieSalleFrance,
                    SEC_TO_TIME(f.duree*60) AS tempsHeure
                FROM
                    appartenir ap
                INNER JOIN film f ON f.id_film = ap.id_film
                INNER JOIN genre g ON g.id_genre = ap.id_genre
                WHERE g.id_genre = $id;";

        $genre = $dao->executerRequete($sql);

        $films = MovieController::getInstance()->getFilmsByGenreId($id);

        require "views/genre/detailGenre.php";
    }


}



?>