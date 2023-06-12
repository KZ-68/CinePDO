<?php

require_once "bdd/DAO.php";

class MovieController {

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
                    f.id_film,
                    f.titre,
                    f.affiche_film,
                    DATE_FORMAT(f.date_sortie_france, '%e %M %Y') AS sortieSalleFrance,
                    DATE_FORMAT(SEC_TO_TIME(f.duree*60), '%H:%i') AS tempsHeure,
                    -- SEC_TO_TIME converti les secondes en HH:MM:SS 
                    -- DATE_FORMAT est une fonction SQL pour formater une date avec le format indiqué, 
                    -- combiné avec SEC_TO_TIME, permet de reduire le format en HH:MM
                    f.note,
                    f.synopsis
                FROM film f
                WHERE f.id_film = :id_film";
            
            $params = [
                ":id_film" => $id
            ];

        $film = $dao->executerRequete($sql, $params);

        $sql2 = "SELECT 
                    g.id_genre,
                    g.libelle    
                FROM genre g 
                INNER JOIN appartenir ap ON ap.id_genre = g.id_genre
                INNER JOIN film f ON f.id_film = ap.id_film
                WHERE f.id_film = :id_film ";

            $params2 = [
                ":id_film" => $id
            ];

        $genreFilm = $dao->executerRequete($sql2, $params2);


        $sql3 = "SELECT 
                p.id_personne,
                r.id_role,
                r.nom_role,
                p.date_naissance,
                p.photo,
                p.prenom,
                p.nom
            FROM personne p
            INNER JOIN acteur a ON a.id_personne = p.id_personne
            INNER JOIN casting c ON c.id_acteur = a.id_acteur
            INNER JOIN role r ON r.id_role = c.id_role
            WHERE c.id_film = :id_film";

        $params3 = [
            ":id_film" => $id 
        ];

        $actorsFilm = $dao->executerRequete($sql3, $params3);

        $sql4 = "SELECT
                f.id_film,
                p.id_personne,
                p.photo,
                CONCAT(p.prenom, ' ', p.nom) AS affichageRea
            FROM film f
            INNER JOIN realisateur re ON re.id_realisateur = f.id_realisateur
            INNER JOIN personne p ON p.id_personne = re.id_personne
            WHERE f.id_film = :id_film";
        
            $params4 = [ 
                ":id_film" => $id
            ];

        $directorFilm = $dao->executerRequete($sql4, $params4);

        require "views/movie/detailFilm.php";
    }

    // find... => récupérer des données depuis la BDD + rediriger vers une view
    // get...  => récupérer des données depuis la BDD et les retourner

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
            $titre = $_POST['titre'];
            $date = $_POST['date_sortie_france'];
            $duree = $_POST['duree'];
            $synopsis = $_POST['synopsis'];
            $note = $_POST['note'];
            $affiche_film = $_POST['affiche_film'];
            $idRealisateur = $_POST['id_realisateur'];

        $sql = "INSERT INTO film (titre, date_sortie_france, duree, synopsis, note, affiche_film,  id_realisateur) 
        VALUES (:titre, :date_sortie_france, :duree, :synopsis, :note, :affiche_film, :id_realisateur)";


        $params = [
            ":titre" => $titre,
            ":date_sortie_france" => $date,
            ":duree" => $duree,
            ":note" => $note,
            ":synopsis" => $synopsis,
            ":affiche_film" => $affiche_film,
            ":id_realisateur" => $idRealisateur
            ];

        $addFilm = $dao->executerRequete($sql, $params);

        }
        require "views/movie/addFilms.php";
    }

    public function modifyFilms($idFilm, $idGenre){
        
        $dao = new DAO();

        // vérifie si la table de la méthode POST existe
        if (isset($_POST['modifyFilm'])) {
            $idFilm = $idFilm;
            $titre = $_POST['titre'];
            $date = $_POST['date_sortie_france'];
            $duree = $_POST['duree'];
            $idGenre = $_POST['id_genre'];
            $synopsis = $_POST['synopsis'];
            $note = $_POST['note'];
            $affiche_film = $_POST['affiche_film'];
            $idRealisateur = $_POST['id_realisateur'];

        $sql = "UPDATE film SET
        id_film = :id_film,
        titre = :titre, 
        date_sortie_france = :date_sortie_france, 
        duree = :duree, 
        synopsis = :synopsis, 
        note = :note, 
        affiche_film = :affiche_film,  
        id_realisateur = :id_realisateur
        WHERE id_film = :id_film";


        $params = [
            ":id_film" => $idFilm,
            ":titre" => $titre,
            ":date_sortie_france" => $date,
            ":duree" => $duree,
            ":note" => $note,
            ":synopsis" => $synopsis,
            ":affiche_film" => $affiche_film,
            ":id_realisateur" => $idRealisateur
            ];
        
        $modifyFilm = $dao->executerRequete($sql, $params);

        }
        require "views/movie/modifyFilms.php";
    }

    public function deleteFilms(){

        $dao = new DAO();

        // vérifie si la table de la méthode POST existe
        if (isset($_POST['deleteFilm'])) {
            $idFilm = $_POST['id_film'];

            $sql = "DELETE FROM film
            WHERE id_film = :id_film";

            $params = [
                ":id_film" => $idFilm
            ];

            $deleteFilm = $dao->executerRequete($sql, $params);

        }
        require "views/movie/deleteFilms.php";
    }

}

?> 