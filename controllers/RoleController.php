<?php

class RoleController{

    public function findAllRoles()  {

        $dao = new DAO();

        $sql = "SELECT
                    ro.id_role,
                    ro.nom_role
                FROM role ro";

        $roles = $dao->executerRequete($sql);

        require "views/role/listRoles.php";
    }
}

?>