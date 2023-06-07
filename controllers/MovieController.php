<?php

require_once "bdd/DAO.php";

class MovieController {

    private static $instance = null;

    public static function getInstance() {
        if (self::$instance) {
            return self::$instance;
        } else {
            self::$instance = new MovieController();
            return self::$instance;
        }
    }

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
                -- on n'utilise pas de GROUP BY par défaut. En cas d'utilisation d'une fonction d'aggrégation (COUNT, SUM, AVG, ...) (les fonctions qui doivent lier des lignes entre elles pour fonctionner), alors on DOIT utiliser GROUP BY.
                -- => on ne choisit pas vraiment quand l'utiliser, c'est à cause des fonctions d'aggrégation qu'on DOIT les utiliser.
                -- GROUP BY 
                --     f.id_film,
                --     f.titre,
                --     f.affiche_film,
                --     sortieSalleFrance,
                --     f.note,
                --     f.synopsis
                ";

        $films = $dao->executerRequete($sql);

        require "views/movie/listFilms.php";
    }

    public function findOneFilm($id) {

        $dao = new DAO();

        $sql = "SELECT
                    f.titre,
                    f.affiche_film,
                    DATE_FORMAT(f.date_sortie_france, '%e %M %Y') AS sortieSalleFrance,
                    SEC_TO_TIME(f.duree*60) AS tempsHeure,
                    f.note,
                    f.synopsis,
                    CONCAT(f.id_realisateur, ' ' ,p.prenom, ' ', p.nom) AS affichageRea
                FROM film f
                INNER JOIN realisateur re ON re.id_realisateur = f.id_realisateur
                INNER JOIN personne p ON p.id_personne = re.id_personne
                WHERE f.id_film = $id;";

        $film = $dao->executerRequete($sql);

        $actors = PersonController::getInstance()->getActorsByFilmId($id);


        require "views/movie/detailFilm.php";
    }

    // find... => récupérer des données depuis la BDD + rediriger vers une view
    // get...  => récupérer des données depuis la BDD et les retourner

    public function getFilmsByActorId($id) {

        $dao = new DAO();

        $sql = "SELECT
                    f.id_film,
                    f.titre,
                    f.affiche_film,
                    DATE_FORMAT(f.date_sortie_france, '%e %M %Y') AS sortieSalleFrance,
                    SEC_TO_TIME(f.duree*60) AS tempsHeure,
                    f.note
                FROM film f
                INNER JOIN casting c ON c.id_film = f.id_film
                INNER JOIN acteur a ON a.id_acteur = c.id_acteur
                WHERE a.id_acteur = $id;
            ";

        $films = $dao->executerRequete($sql);

        return $films;
    }

    public function getFilmsByDirectorId($id) {

        $dao = new DAO();

        $sql = "SELECT
                    f.id_film,
                    f.titre,
                    f.affiche_film,
                    DATE_FORMAT(f.date_sortie_france, '%e %M %Y') AS sortieSalleFrance,
                    SEC_TO_TIME(f.duree*60) AS tempsHeure,
                    f.note
                FROM film f
                INNER JOIN casting c ON c.id_film = f.id_film
                INNER JOIN realisateur re ON re.id_realisateur = f.id_realisateur
                WHERE re.id_realisateur = $id;
            ";

        $films = $dao->executerRequete($sql);

        return $films;
    }

    public function getFilmsByRoleId($id) {

        $dao = new DAO();

        $sql = "SELECT
                    f.id_film,
                    f.titre,
                    f.affiche_film,
                    DATE_FORMAT(f.date_sortie_france, '%e %M %Y') AS sortieSalleFrance,
                    SEC_TO_TIME(f.duree*60) AS tempsHeure,
                    f.note
                FROM film f
                INNER JOIN casting c ON c.id_film = f.id_film
                INNER JOIN role ro ON ro.id_role = c.id_role
                WHERE ro.id_role = $id;
            ";

        $films = $dao->executerRequete($sql);

        return $films;
    }

    public function getFilmsByGenreId($id) {

        $dao = new DAO();

        $sql = "SELECT
                    f.id_film,
                    f.titre,
                    f.affiche_film,
                    DATE_FORMAT(f.date_sortie_france, '%e %M %Y') AS sortieSalleFrance,
                    SEC_TO_TIME(f.duree*60) AS tempsHeure,
                    f.note
                FROM appartenir ap
                INNER JOIN film f ON f.id_film = ap.id_film
                INNER JOIN genre g ON g.id_genre = ap.id_genre
                WHERE g.id_genre = $id;
            ";

        $films = $dao->executerRequete($sql);

        return $films;
    }

}

?> 