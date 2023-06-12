<?php

require_once "bdd/DAO.php";

class PersonController{
    
    public function findAllActors()  {

        $dao = new DAO();

        $sql = "SELECT
                    a.id_acteur,
                    p.id_personne,
                    p.photo,
                    p.prenom,
                    p.nom,
                    p.sexe,
                    p.date_naissance
                FROM
                    personne p
                INNER JOIN acteur a ON a.id_personne = p.id_personne";

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
                WHERE ac.id_acteur = :id_acteur";

            $params = [
                ":id_acteur" => $id
            ];

        $actor = $dao->executerRequete($sql, $params);

        $sql2 = "SELECT
                    f.id_film,
                    f.titre,
                    f.affiche_film
                FROM
                    casting c
                INNER JOIN film f ON f.id_film = c.id_film
                INNER JOIN acteur ac ON ac.id_acteur = c.id_acteur
                WHERE c.id_acteur = :id_acteur";
        
            $params2 = [
                ":id_acteur" => $id
            ];

        $filmsActor = $dao->executerRequete($sql2, $params2);

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
                    re.id_realisateur,
                    p.photo,
                    p.prenom,
                    p.nom,
                    p.sexe,
                    p.date_naissance
                FROM
                    film f
                INNER JOIN realisateur re ON re.id_realisateur = f.id_realisateur
                INNER JOIN personne p ON p.id_personne = re.id_personne
                WHERE re.id_realisateur = :id_realisateur";

            $params = [
                ":id_realisateur" => $id,
            ];

        // $films = MovieController::getInstance()->getFilmsByDirectorId($id);
        $director = $dao->executerRequete($sql, $params);

        $sql2 = "SELECT 
                    f.id_film,
                    f.titre,
                    f.affiche_film
                FROM
                    film f
                INNER JOIN realisateur re ON re.id_realisateur = f.id_realisateur
                WHERE f.id_realisateur = :id_realisateur";

        $params2 = [
            ":id_realisateur" => $id
        ];

        $directorFilms = $dao->executerRequete($sql2, $params2);

        require "views/director/detailDirector.php";
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

    public function addPersons(){
        
        $dao = new DAO();

        // vérifie si la table de la méthode POST existe
        if (isset($_POST['addPerson'])) {
            $photo = $_POST['photo'];
            $prenom = $_POST['prenom'];
            $nom = $_POST['nom'];
            $sexe = $_POST['sexe'];
            $dateNaissance = $_POST['date_naissance'];

        $sql = "INSERT INTO personne (photo, prenom, nom, sexe, date_naissance) 
        VALUES (:photo, :prenom, :nom, :sexe, :date_naissance)";

        $params = [
            ":photo" => $photo,
            ":prenom" => $prenom,
            ":nom" => $nom,
            ":sexe" => $sexe,
            ":date_naissance" => $dateNaissance
            ];

        $addPerson = $dao->executerRequete($sql, $params);

        }

        require "views/person/addPersons.php";
    }

    public function addDirectors(){
        
        $dao = new DAO();

        // vérifie si la table de la méthode POST existe
        if (isset($_POST['addDirector'])) {
            $idPersonne = $_POST['id_personne'];

        $sql = "INSERT INTO realisateur (id_personne) 
        VALUES (:id_personne)";

        $params = [
            ":id_personne" => $idPersonne
            ];

        $addPerson = $dao->executerRequete($sql, $params);

        }

        require "views/director/addDirectors.php";
    }

    public function addActors(){
        
        $dao = new DAO();

        // vérifie si la table de la méthode POST existe
        if (isset($_POST['addActor'])) {
            $idPersonne = $_POST['id_personne'];

        $sql = "INSERT INTO acteur (id_personne) 
        VALUES (:id_personne)";

        $params = [
            ":id_personne" => $idPersonne
            ];

        $addPerson = $dao->executerRequete($sql, $params);

        }

        require "views/actor/addActors.php";
    }


}

?>