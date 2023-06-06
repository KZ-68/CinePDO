<?php

require_once "bdd/DAO.php";

class PersonController{
    
    public function findAllActors()  {

        $dao = new DAO();

        $sql = "SELECT
                    ac.id_acteur,
                    p.id_personne,
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

    public function findAllDirectors()  {

        $dao = new DAO();

        $sql = "SELECT
                    re.id_realisateur,
                    p.id_personne,
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

    public function findOneActor($id)  {

        $dao = new DAO();

        $sql = "SELECT
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

        require "views/actor/detailActor.php";
    }

    public function findOneDirector($id)  {

        $dao = new DAO();

        $sql = "SELECT
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

        require "views/director/detailDirector.php";
    }
}

?>