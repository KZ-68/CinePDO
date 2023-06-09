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
    // On met l'id de la table en argumant pour l'utiliser dans l'index 

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

        $genreFilm = $dao->executerRequete($sql2, $params);


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

        $actorsFilm = $dao->executerRequete($sql3, $params);

        $sql4 = "SELECT
                f.id_film,
                p.id_personne,
                p.photo,
                CONCAT(p.prenom, ' ', p.nom) AS affichageRea
            FROM film f
            INNER JOIN realisateur re ON re.id_realisateur = f.id_realisateur
            INNER JOIN personne p ON p.id_personne = re.id_personne
            WHERE f.id_film = :id_film";

        $directorFilm = $dao->executerRequete($sql4, $params);

        require "views/movie/detailFilm.php";
    }

    // find... => récupérer des données depuis la BDD + rediriger vers une view
    // get...  => récupérer des données depuis la BDD et les retourner

    // public function getFilmsByRoleId($id) {

    //     $dao = new DAO();

    //     $sql = "SELECT
    //                 f.id_film,
    //                 f.titre,
    //                 f.affiche_film,
    //                 DATE_FORMAT(f.date_sortie_france, '%e %M %Y') AS sortieSalleFrance,
    //                 SEC_TO_TIME(f.duree*60) AS tempsHeure,
    //                 f.note
    //             FROM film f
    //             INNER JOIN casting c ON c.id_film = f.id_film
    //             INNER JOIN role ro ON ro.id_role = c.id_role
    //             WHERE ro.id_role = $id;
    //         ";

    //     $films = $dao->executerRequete($sql);

    //     return $films;
    // }

    public function openFilmsForm() {
        
        $dao = new DAO();

        $sql = "SELECT re.id_realisateur, p.nom, p.prenom 
                        FROM realisateur re
                        INNER JOIN personne p ON re.id_personne = p.id_personne";

        $filmDirector = $dao->executerRequete($sql);

        $sql2 = "SELECT g.id_genre, g.libelle
                FROM genre g";              
            
        $filmGenres = $dao->executerRequete($sql2);

        require "views/movie/filmsForm.php";
    }

    public function addFilms($array) {
        
        $dao = new DAO();
        
        $sql = "INSERT INTO film (titre, date_sortie_france, duree, note, id_realisateur, affiche_film, synopsis) 
        VALUES (:titre, :date_sortie_france, :duree, :note, :id_realisateur, :affiche_film, :synopsis)";

        $titre = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);  
        $date_sortie = filter_input(INPUT_POST, "date_sortie_france");
        $duree = filter_input(INPUT_POST, "duree", FILTER_SANITIZE_NUMBER_INT);
        $synopsis = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);               
        $note = filter_input(INPUT_POST, "note", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $idRealisateur = filter_input(INPUT_POST,'id_realisateur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $idGenres = filter_var_array($array['id_genre'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $affiche_film = filter_input(INPUT_POST, "affiche_film", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $dao->executerRequete($sql, ['titre' => $titre, 'date_sortie_france' => $date_sortie, 'duree' => $duree, 'note' => $note, 'id_realisateur' =>  $idRealisateur, 'synopsis' => $synopsis, 'affiche_film' => $affiche_film]);
        

        $sql2 = "INSERT INTO appartenir (id_film, id_genre)
        VALUES (:id_film, :id_genre)"; 
        
        $lastFilmId = $dao->getBDD()->lastInsertId(); // retourne le dernier identifiant insérée par PDO

        foreach ($idGenres as $id_genre) {

            $dao->executerRequete($sql2, [':id_film' => $lastFilmId, ':id_genre' => $id_genre]);
            
        }         

        // Comme la session est déjà démarré dans les autres fichiers, on peut créer un tableau de $_SESSION pour afficher un message
        $_SESSION['flash_message'] = "Le film " .$titre. " à été ajouté avec succès !";
        // Retourne l'objet en cours et réaffiche la liste des films 
        $this->findAllFilms();
    }

    public function openUpdateFilmsForm($id) {
        
        $dao = new DAO();

        $sql = "SELECT 
                    f.id_film, 
                    f.titre, 
                    f.date_sortie_france, 
                    f.duree, 
                    f.synopsis, 
                    f.note, 
                    f.affiche_film, 
                    f.id_realisateur
                FROM film f
                WHERE id_film = $id";

        $idFilmsForm = $dao->executerRequete($sql);

        $sql2 = "SELECT 
                    re.id_realisateur, 
                    p.nom, 
                    p.prenom 
                FROM realisateur re
                INNER JOIN personne p ON re.id_personne = p.id_personne";

        $filmDirector = $dao->executerRequete($sql2);

        $sql3 = "SELECT g.id_genre, g.libelle
                FROM genre g";              
            
        $filmGenresForm = $dao->executerRequete($sql3);

        require "views/movie/updateFilmsForm.php";
    }

    public function updateFilms($id, $array){
        
        $dao = new DAO();

        // vérifie si la table de la méthode POST existe
        if (isset($_POST['updateFilm'])) {
            
            $sql = "UPDATE film SET
                        titre = :titre, 
                        date_sortie_france = :date_sortie_france, 
                        duree = :duree, 
                        synopsis = :synopsis, 
                        note = :note, 
                        affiche_film = :affiche_film,  
                        id_realisateur = :id_realisateur
                    WHERE id_film = $id";

            $titre = filter_input(INPUT_POST,'titre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date = filter_input(INPUT_POST,'date_sortie_france');
            $duree = filter_input(INPUT_POST,'duree', FILTER_SANITIZE_NUMBER_INT);
            $synopsis = filter_input(INPUT_POST,'synopsis', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $note = filter_input(INPUT_POST,'note', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $affiche_film = filter_input(INPUT_POST,'affiche_film', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $idGenres = filter_var_array($array['id_genre'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $idRealisateur = filter_input(INPUT_POST,'id_realisateur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $params = [
                ":titre" => $titre,
                ":date_sortie_france" => $date,
                ":duree" => $duree,
                ":note" => $note,
                ":synopsis" => $synopsis,
                ":affiche_film" => $affiche_film,
                ":id_realisateur" => $idRealisateur
                ];
            
            $dao->executerRequete($sql, $params);

            $sql2 = "DELETE FROM appartenir
                    WHERE id_film = :id_film";            

            $dao->executerRequete($sql2, [':id_film' => $id]);              
                

            $sql3 = "INSERT INTO appartenir (id_film, id_genre)
            VALUES (:id_film, :id_genre);"; 

            foreach ($idGenres as $id_genre) {

                $dao->executerRequete($sql3, [':id_film'=> $id, ':id_genre' => $id_genre]);
                
            }   

        }
        
        $_SESSION['flash_message'] = "Le film $titre à été mis à jour avec succès !";
        $this->findAllFilms();
    }

    public function openDeleteFilmsForm() {
        
        $dao = new DAO();

        $sql = "SELECT 
                    f.id_film, 
                    f.titre, 
                    f.date_sortie_france, 
                    f.duree, 
                    f.synopsis, 
                    f.note, 
                    affiche_film, 
                    f.id_realisateur
                FROM film f";

        $films = $dao->executerRequete($sql);

        require "views/movie/deleteFilmsForm.php";
    }

    public function deleteFilms() {

        $dao = new DAO();

        // vérifie si la table de la méthode POST existe
        if (isset($_POST['deleteFilm'])) {
            $idFilm = $_POST['id_film'];

            $sql2 = "DELETE FROM appartenir ap
                    WHERE ap.id_film = :id_film;
                    DELETE FROM casting c
                    WHERE c.id_film = :id_film;
                    DELETE FROM film f
                    WHERE f.id_film = :id_film";

            $params = [
                ":id_film" => $idFilm 
            ];

            $dao->executerRequete($sql2, $params);
        }

        $_SESSION['flash_message'] = "Le film à été supprimé avec succès !";
        $this->findAllFilms();
    }

    public function openAddCastingsForm($id) {
        
        $dao = new DAO();

        $sql = "SELECT
                    f.id_film,
                    f.titre
                FROM 
                    film f
                WHERE f.id_film = $id";

        $filmCasting = $dao->executerRequete($sql);
        
        $sql2 = "SELECT
                    a.id_acteur,
                    p.prenom,
                    p.nom
                FROM 
                    acteur a
                INNER JOIN personne p ON p.id_personne = a.id_personne";

        $actorCasting = $dao->executerRequete($sql2);        

        $sql3 = "SELECT
                    ro.id_role,
                    ro.nom_role
                FROM 
                    role ro";

        $roleCasting = $dao->executerRequete($sql3);

        require "views/movie/addCastingsForm.php";
    }

    public function addCastings($id) {

        $dao = new DAO();    

        if (isset($_POST['addCasting'])) {

            $sql4 = "INSERT INTO casting (id_film, id_acteur, id_role)
            VALUES (:id_film, :id_acteur, :id_role)"; 
    
            $idActor = filter_input(INPUT_POST, 'id_acteur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $idRole = filter_input(INPUT_POST, 'id_role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            /* On ajoute tous les paramètres en une fois car on souhaite ajouter un casting pour UN film précis, 
            par le biais de son id, et un acteur aura un seul role */
                $params = [
                    ":id_film" => $id,
                    ":id_acteur" => $idActor,
                    ":id_role" => $idRole
                ];

                $dao->executerRequete($sql4, $params);

        }
        
        $_SESSION['flash_message'] = "Le casting à été ajouté avec succès !";
        $this->findAllFilms();
    }

    public function openUpdateCastingsForm($id) {
        
        $dao = new DAO();

        $sql = "SELECT
                    f.id_film,
                    f.titre
                FROM 
                    film f
                WHERE f.id_film = $id";

        $filmCasting = $dao->executerRequete($sql);
        
        $sql2 = "SELECT
                    a.id_acteur,
                    p.prenom,
                    p.nom
                FROM 
                    acteur a
                INNER JOIN personne p ON p.id_personne = a.id_personne";

        $actorCasting = $dao->executerRequete($sql2);        

        $sql3 = "SELECT
                    ro.id_role,
                    ro.nom_role
                FROM 
                    role ro";

        $roleCasting = $dao->executerRequete($sql3);

        require "views/movie/updateCastingsForm.php";
    }

    public function updateCastings($id) {

        $dao = new DAO();

        if (isset($_POST['updateCasting'])) {

            $sql4 = "UPDATE casting SET
            id_film = :id_film,
            id_acteur = :id_acteur,
            id_role = :id_role
            WHERE id_film = $id"; 
    
            $idActor = filter_input(INPUT_POST, 'id_acteur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $idRole = filter_input(INPUT_POST, 'id_role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            /* On ajoute tous les paramètres en une fois car on souhaite ajouter un casting pour UN film précis, 
            par le biais de son id, et un acteur aura un seul role */
                $params = [
                    ":id_film" => $id,
                    ":id_acteur" => $idActor,
                    ":id_role" => $idRole
                ];

                $dao->executerRequete($sql4, $params);

        }

        $_SESSION['flash_message'] = "Le casting à été mis à jour avec succès !";
        $this->findAllFilms();
    }

    public function openDeleteCastingsForm($id) {
        
        $dao = new DAO();

        $sql = "SELECT
                    c.id_film,
                    f.id_film,
                    f.titre
                FROM 
                    casting c
                INNER JOIN film f ON f.id_film = c.id_film
                WHERE f.id_film = $id";

        $filmCasting = $dao->executerRequete($sql);
        
        $sql2 = "SELECT
                    c.id_acteur,
                    p.prenom,
                    p.nom
                FROM 
                    casting c
                INNER JOIN acteur a ON a.id_acteur = c.id_acteur
                INNER JOIN personne p ON p.id_personne = a.id_personne
                WHERE id_film = $id";

        $actorCasting = $dao->executerRequete($sql2);        

        $sql3 = "SELECT
                    c.id_role,
                    ro.nom_role
                FROM 
                    casting c
                INNER JOIN role ro ON ro.id_role = c.id_role
                WHERE id_film = $id";

        $roleCasting = $dao->executerRequete($sql3);

        require "views/movie/deleteCastingsForm.php";
    }

    public function deleteCastings($id) {

        $dao = new DAO();

        // vérifie si la table de la méthode POST existe
        if (isset($_POST['deleteCasting'])) {

            $sql4 = "DELETE FROM casting c
                    WHERE c.id_acteur = :id_acteur;
                    AND
                    WHERE c.id_role = :id_role";

            $idActor = filter_input(INPUT_POST, 'id_acteur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $idRole = filter_input(INPUT_POST, 'id_role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $params = [
                ":id_acteur" => $idActor,
                ":id_role" => $idRole
            ];

            $dao->executerRequete($sql4, $params);
        }
        
        $_SESSION['flash_message'] = "Le casting à été supprimé avec succès !";
        $this->findAllFilms();
    }
}

?> 