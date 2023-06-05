<!-- 
DAO - Data Access Object
PDO -->

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
            // query : à définir        
        }else{            
            $resultat = $this->bdd->prepare($sql);           
            $resultat->execute($params);        
        }        
        return $resultat;    
    }
}
