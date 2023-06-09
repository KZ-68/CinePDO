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

    public function addFilms(){
        
        $dao = new DAO();

        // vérifie si la table de la méthode POST existe
        if (isset($_POST['addFilm'])) {
            $idFilm = $_GET['id_film'];
            $titre = $_POST['titre'];
            $date = $_POST['date_sortie_france'];
            $duree = $_POST['duree'];
            $synopsis = $_POST['synopsis'];
            $note = $_POST['note'];
            $affiche_film = $_POST['affiche_film'];
            $genre = $_POST['id_genre'];
            $idRealisateur = $_POST['id_realisateur'];

        $sql = "INSERT INTO film (titre, date_sortie_france, duree, synopsis, note, affiche_film,  id_realisateur) 
        VALUES (:titre, :date_sortie_france, :duree, :synopsis, :note, :affiche_film, :id_realisateur)";

        $params = [
            ":titre" => $titre,
            ":date_sortie_france" => $date,
            ":duree" => $duree,
            ":note" => $note,
            ":synopsis" => $synopsis,
            ":affiche_film" => "<img class='posterMovie' src='public/image/{$affiche_film}'>",
            ":id_realisateur" => $idRealisateur
            ];

        $addFilm = $dao->executerRequete($sql, $params);

        // Vérifiez si l'ID du film est valide avant d'insérer dans la table "appartenir"
        if ($idFilm) {
            // Insérez les données dans la table "appartenir"
            $sqlAppartenir = "INSERT INTO appartenir (id_film, id_genre) VALUES (:id_film, :id_genre)";
            $paramsAppartenir = [
                            ":id_film" => $idFilm,
                            ":id_genre" => $genre
                            ];
            $addAppartenir = $dao->executerRequete($sqlAppartenir, $paramsAppartenir);
            };

        }
        require "views/movie/addFilms.php";
    }


}

?> 