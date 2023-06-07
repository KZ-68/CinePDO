<?php

require_once "bdd/DAO.php";

class PersonController{

    private static $instance = null;

    public static function getInstance() {
        if (self::$instance) {
            return self::$instance;
        } else {
            self::$instance = new PersonController();
            return self::$instance;
        }
    }
    
    public function findAllActors()  {

        $dao = new DAO();

        $sql = "SELECT
                    ac.id_acteur,
                    p.id_personne,
                    p.photo,
                    p.prenom,
                    p.nom,
                    p.sexe,
                    p.date_naissance
                FROM
                    personne p
                INNER JOIN acteur ac ON ac.id_personne = p.id_personne";

        $actors = $dao->executerRequete($sql);

        require "views/actor/listActors.php";
    }

    public function findOneActor($id)  {

        $dao = new DAO();

        $sql = "SELECT
                    p.photo,
                    p.prenom,
                    p.nom,
                    p.sexe,
                    p.date_naissance
                FROM
                    casting c
                INNER JOIN acteur ac ON ac.id_acteur = c.id_acteur
                INNER JOIN personne p ON p.id_personne = ac.id_personne
                WHERE ac.id_acteur = $id;";

        $actor = $dao->executerRequete($sql);

        $films = MovieController::getInstance()->getFilmsByActorId($id);

        require "views/actor/detailActor.php";
    }


    public function findAllDirectors()  {

        $dao = new DAO();

        $sql = "SELECT
                    re.id_realisateur,
                    p.id_personne,
                    p.photo,
                    p.prenom,
                    p.nom,
                    p.sexe,
                    p.date_naissance
                FROM
                    personne p
                INNER JOIN realisateur re ON re.id_personne = p.id_personne";

        $directors = $dao->executerRequete($sql);

        require "views/director/listDirectors.php";
    }

    public function findOneDirector($id)  {

        $dao = new DAO();

        $sql = "SELECT
                    p.photo,
                    p.prenom,
                    p.nom,
                    p.sexe,
                    p.date_naissance
                FROM
                    casting c
                INNER JOIN film f ON f.id_film = c.id_film
                INNER JOIN realisateur re ON re.id_realisateur = f.id_realisateur
                INNER JOIN personne p ON p.id_personne = re.id_personne
                WHERE re.id_realisateur = $id;";

        $director = $dao->executerRequete($sql);

        $films = MovieController::getInstance()->getFilmsByDirectorId($id);

        require "views/director/detailDirector.php";
    }

    public function getActorsByFilmId($id) {

        $dao = new DAO();

        $sql = "SELECT
                    a.id_acteur,
                    p.photo,
                    p.prenom,
                    p.nom
                FROM acteur a
                INNER JOIN personne p ON p.id_personne = a.id_personne
                INNER JOIN casting c ON c.id_acteur = a.id_acteur
                INNER JOIN film f ON f.id_film = c.id_film
                WHERE f.id_film = $id;";

        $actors = $dao->executerRequete($sql);

        return $actors;
    }

    public function getActorsByRoleId($id) {

        $dao = new DAO();

        $sql = "SELECT
                    a.id_acteur,
                    p.photo,
                    p.prenom,
                    p.nom
                FROM acteur a
                INNER JOIN personne p ON p.id_personne = a.id_personne
                INNER JOIN casting c ON c.id_acteur = a.id_acteur
                INNER JOIN role ro ON ro.id_role = c.id_role
                WHERE ro.id_role = $id;";

        $actors = $dao->executerRequete($sql);

        return $actors;
    }

}

?>