<!-- 
DAO - Data Access Object est un Design Pattern utilisé pour regrouper les accès aux données dans des classes à part
PDO - PDO (PHP Data Object) est une extension de PHP permettant d'accéder à une base de données -->

<?php
class DAO{    
    private $bdd;    
    
    public function __construct(){        
        $this->bdd = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8', 'root', '');    
    }    
    
    function getBDD() {        
        return $this->bdd;    
    }    
    
    public function executerRequete($sql, $params = NULL) {        
        if ($params == NULL){            
            $resultat = $this->bdd->query($sql);
            // query : Prépare et Exécute une requête SQL  
        }else{            
            $resultat = $this->bdd->prepare($sql);           
            $resultat->execute($params);        
        }        
        return $resultat;    
    }
}
