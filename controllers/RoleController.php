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
                    ro.nom_role
                FROM
                    role ro
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

    public function openRolesForm() {
        
        $dao = new DAO();

        require "views/role/rolesForm.php";
    }

    public function addRoles(){
        
        $dao = new DAO();

        $sql = "INSERT INTO role (nom_role) 
        VALUES (:nom_role)";

        $nomRole = filter_input(INPUT_POST, 'nom_role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);  

        $params = [
            ":nom_role" => $nomRole
            ];

        $dao->executerRequete($sql, $params);

        // Comme la session est déjà démarré dans les autres fichiers, on peut créer un tableau de $_SESSION pour afficher un message
        $_SESSION['flash_message'] = "Le rôle de " .$nomRole. " à été ajouté avec succès !";
        // Retourne l'objet en cours et réaffiche la liste des genres 
        $this->findAllRoles();
    }

    public function openUpdateRolesForm($id) {
        
        $dao = new DAO();

        $sql = "SELECT
                    id_role
                FROM
                    role
                WHERE id_role = $id";
        
        $idRoleForm = $dao->executerRequete($sql);

        require "views/role/updateRolesForm.php";
    }

    public function updateRoles($id) {
        
        $dao = new DAO();

        if (isset($_POST['updateRole'])) {
        $sql = "UPDATE role SET 
                    nom_role = :nom_role
                WHERE id_role = $id";
        
            $nomRole = filter_input(INPUT_POST, 'nom_role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $params = [
                ":nom_role" => $nomRole
            ];

        $dao->executerRequete($sql, $params);

        } 

        $_SESSION['flash_message'] = "Le rôle de " .$nomRole. " à été mis à jour avec succès !";
        $this->findAllRoles();
    }

    public function openDeleteRolesForm() {
        
        $dao = new DAO();

        $sql = "SELECT
                    ro.id_role,
                    ro.nom_role
                FROM role ro";

        $roles = $dao->executerRequete($sql);

        require "views/role/deleteRolesForm.php";
    }

    public function deleteRoles() {

        $dao = new DAO();

        // vérifie si la table de la méthode POST existe
        if (isset($_POST['deleteRole'])) {
            $idRole = $_POST['id_role'];

            $sql2 ="DELETE FROM casting c
                    WHERE c.id_role = :id_role;
            
                    DELETE FROM role ro
                    WHERE ro.id_role = :id_role";

            $params = [
                ":id_role" => $idRole 
            ];

            $dao->executerRequete($sql2, $params);
        }
        
        $_SESSION['flash_message'] = "Le rôle à été supprimé avec succès !";
        $this->findAllRoles();
    }
}

?>