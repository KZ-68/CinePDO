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

    public function findAllPersons()  {

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

        $personActors = $dao->executerRequete($sql);

        $sql2 = "SELECT
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
        
        $personDirectors = $dao->executerRequete($sql2);

        require "views/person/listPersons.php";
    }

    public function openPersonsForm() {
        
        $dao = new DAO();

        require "views/person/personsForm.php";
    }

    public function addPersons($array){
        
        $dao = new DAO();
            
        $sql = "INSERT INTO personne (photo, prenom, nom, sexe, date_naissance) 
        VALUES (:photo, :prenom, :nom, :sexe, :date_naissance)";

        $photo = filter_var($array["photo"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);  
        $prenom = filter_var($array["prenom"], FILTER_SANITIZE_SPECIAL_CHARS);
        $nom = filter_var($array["nom"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sexe = filter_var($array["sexe"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);               
        $dateNaissance = filter_var($array["date_naissance"]);

        $params = [
            ":photo" => $photo,
            ":prenom" => $prenom,
            ":nom" => $nom,
            ":sexe" => $sexe,
            ":date_naissance" => $dateNaissance
            ];

        $addPerson = $dao->executerRequete($sql, $params);

        // Comme la session est déjà démarré dans les autres fichiers, on peut créer un tableau de $_SESSION pour afficher un message
        $_SESSION['flash_message'] = "".$prenom." ".$nom." à été ajouté avec succès !";
        // Retourne l'objet en cours et réaffiche la liste des films 
        $this->findAllPersons();

    }

    public function addDirectors(){
        
        $dao = new DAO();

        $sql = "SELECT p.id_personne, p.nom, p.prenom 
                        FROM personne p";
        $result = $dao->executerRequete($sql);
                
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

        $sql = "SELECT p.id_personne, p.nom, p.prenom
                FROM personne p";
        $result = $dao->executerRequete($sql);

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

    public function editActors($id){
        
        $dao = new DAO();

        // vérifie si la table de la méthode POST existe
        if (isset($_POST['editActor'])) {

        $sql = "UPDATE personne SET
                photo = :photo,
                prenom = :prenom,
                nom = :nom,
                sexe = :sexe,
                date_naissance = :date_naissance
                INNER JOIN acteur a ON a.id_personne = p.id_personne
                WHERE a.id_acteur = $id";

                $photo = filter_input(INPUT_POST, 'photo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $sexe = filter_input(INPUT_POST, 'sexe', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $date_naissance = filter_input(INPUT_POST, 'date_naissance');

        $params = [
            ":photo" => $photo,
            ":prenom" => $prenom,
            ":nom" => $nom,
            ":sexe" => $sexe,
            ":date_naissance" => $date_naissance
            ];

        $editPerson = $dao->executerRequete($sql, $params);

        }

        require "views/actor/editActors.php";
    }

    public function deleteDirectors(){
        
        $dao = new DAO();

        $sql = "SELECT re.id_realisateur, p.nom, p.prenom 
        FROM realisateur re
        INNER JOIN personne p ON re.id_personne = p.id_personne";

        $director = $dao->executerRequete($sql);

        if (isset($_POST['deleteDirector'])) {
            $idDirector = $_POST['id_realisateur'];

        $sql2 ="DELETE FROM realisateur re
                WHERE re.id_realisateur = :id_realisateur;
        
                DELETE FROM film f
                WHERE f.id_realisateur = :id_realisateur";

        $params2 = [
            ":id_realisateur" => $idDirector
        ];

        $deleteDirector = $dao->executerRequete($sql2, $params2);

        }

        require "views/director/deleteDirectors.php";
    }

    public function deleteActors(){
        
        $dao = new DAO();

        $sql = "SELECT a.id_acteur, p.nom, p.prenom 
                FROM acteur a
                INNER JOIN personne p ON a.id_personne = p.id_personne";

        $actor = $dao->executerRequete($sql);

        if (isset($_POST['deleteActor'])) {
            $idActor = $_POST['id_acteur'];

        $sql2 ="DELETE FROM acteur a
                WHERE a.id_acteur = :id_acteur;
        
                DELETE FROM casting c
                WHERE c.id_acteur = :id_acteur";

        $params2 = [
            ":id_acteur" => $idActor
        ];

        $deleteActor = $dao->executerRequete($sql2, $params2);

        }

        require "views/actor/deleteActors.php";
    }
}

?>