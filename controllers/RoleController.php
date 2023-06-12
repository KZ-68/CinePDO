<?php

require_once "bdd/DAO.php";

class RoleController{
    
    // private static $instance = null;

    // public static function getInstance() {
    //     if (self::$instance) {
    //         return self::$instance;
    //     } else {
    //         self::$instance = new RoleController();
    //         return self::$instance;
    //     }
    // }

    public function findAllRoles()  {

        $dao = new DAO();

        $sql = "SELECT
                    ro.id_role,
                    ro.nom_role
                FROM role ro";

        $roles = $dao->executerRequete($sql);

        require "views/role/listRoles.php";
    }

    public function findOneRole($id)  {

        $dao = new DAO();

        $sql = "SELECT
                    ro.id_role,
                    ro.nom_role,
                    f.titre,
                    DATE_FORMAT(f.date_sortie_france, '%e %M %Y') AS sortieSalleFrance,
                    SEC_TO_TIME(f.duree*60) AS tempsHeure
                FROM
                    casting c
                INNER JOIN role ro ON ro.id_role = c.id_role
                INNER JOIN film f ON f.id_film = c.id_film
                WHERE ro.id_role = :id_role";

            $params = [
                ":id_role" => $id
            ];

        $role = $dao->executerRequete($sql, $params);

        $sql2 = "SELECT
                    f.id_film,
                    f.titre,
                    f.affiche_film
                FROM 
                    casting c 
                INNER JOIN film f ON f.id_film = c.id_film
                INNER JOIN role ro ON ro.id_role = c.id_role
                WHERE ro.id_role = :id_role";

            $params2 = [
                ":id_role" => $id
            ];

        $filmsRole = $dao->executerRequete($sql2, $params2);

        $sql3 = "SELECT
                    c.id_acteur,
                    p.photo,
                    p.prenom,
                    p.nom
                FROM
                    casting c
                INNER JOIN acteur a ON a.id_acteur = c.id_acteur
                INNER JOIN personne p ON p.id_personne = a.id_personne
                INNER JOIN role ro ON ro.id_role = c.id_role
                WHERE ro.id_role = :id_role";

            $params3 = [
                ":id_role" => $id
            ];

        $actorsRole = $dao->executerRequete($sql3, $params3);

        require "views/role/detailRole.php";
    }

    public function addRoles(){
        
        $dao = new DAO();

        // vérifie si la table de la méthode POST existe
        if (isset($_POST['addRole'])) {
            $nomRole = $_POST['nom_role'];

        $sql = "INSERT INTO role (nom_role) 
        VALUES (:nom_role)";

        $params = [
            ":nom_role" => $nomRole
            ];

        $addRole = $dao->executerRequete($sql, $params);

        }

        require "views/role/addRoles.php";
    }
}

?>