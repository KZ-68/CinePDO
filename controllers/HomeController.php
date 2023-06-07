<?php


class HomeController{

    public function homePage() {

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
                    WHERE f.id_film BETWEEN 1 AND 5";
    
            $films = $dao->executerRequete($sql);
        
        require "views/home/homePage.php";
    }


}

?>