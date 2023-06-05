<?php

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
}

?>