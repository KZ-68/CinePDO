<?php

require_once "bdd/DAO.php";

class GenreController{

    public function findAllGenres()  {

        $dao = new DAO();

        $sql = "SELECT
                g.id_genre,
                g.libelle
                FROM
                genre g";

        $genres = $dao->executerRequete($sql);

        require "views/genre/listGenres.php";
    }

    public function findOneGenre($id)  {

        $dao = new DAO();

        $sql = "SELECT
                    g.id_genre,
                    g.libelle,
                    f.id_film,
                    f.titre,
                    f.affiche_film,
                    DATE_FORMAT(f.date_sortie_france, '%e %M %Y') AS sortieSalleFrance,
                    SEC_TO_TIME(f.duree*60) AS tempsHeure
                FROM
                    appartenir ap
                INNER JOIN film f ON f.id_film = ap.id_film
                INNER JOIN genre g ON g.id_genre = ap.id_genre
                WHERE ap.id_genre = :id_genre";

            $params = [
                ":id_genre" => $id
            ];

        $genre = $dao->executerRequete($sql, $params);

        $sql2 = "SELECT
                    f.id_film,
                    f.titre,
                    f.affiche_film
                FROM
                    appartenir ap
                INNER JOIN film f ON f.id_film = ap.id_film
                INNER JOIN genre g ON g.id_genre = ap.id_genre
                WHERE ap.id_genre = :id_genre";

            $params2 = [
                ":id_genre" => $id
            ];

            $filmsGenre = $dao->executerRequete($sql2, $params2);

        require "views/genre/detailGenre.php";
    }

    public function openGenresForm() {
        
        $dao = new DAO();

        require "views/genre/genresForm.php";
    }

    public function addGenres(){
        
        $dao = new DAO();

        // vérifie si la table de la méthode POST existe

        $sql = "INSERT INTO genre (libelle) 
        VALUES (:libelle)";
        
        $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $params = [
            "libelle" => $libelle
            ];

        $dao->executerRequete($sql, $params);

        // Comme la session est déjà démarré dans les autres fichiers, on peut créer un tableau de $_SESSION pour afficher un message
        $_SESSION['flash_message'] = "Le genre " .$libelle. " à été ajouté avec succès !";
        // Retourne l'objet en cours et réaffiche la liste des genres 
        $this->findAllGenres();
    }

    public function updateGenres($id) {
        
        $dao = new DAO();

        if (isset($_POST['updateGenre'])) {
        $sql = "UPDATE genre SET 
                    libelle = :libelle
                WHERE id_genre = $id";
        
            $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $params = [
                ":libelle" => $libelle
            ];

        $dao->executerRequete($sql, $params);

        } 

        require  "views/genre/updateGenres.php";
    }

    public function deleteGenres(){

        $dao = new DAO();

        $sql = "SELECT g.id_genre, g.libelle
                FROM genre g";

        $genre = $dao->executerRequete($sql);

        // vérifie si la table de la méthode POST existe
        if (isset($_POST['deleteGenre'])) {
            $idGenre = $_POST['id_genre'];

            $sql2 = "DELETE FROM genre
            WHERE id_genre = :id_genre;
            
            DELETE FROM appartenir
            WHERE id_genre = :id_genre";

            $params = [
                ":id_genre" => $idGenre
            ];

            $dao->executerRequete($sql2, $params);

        }
        require "views/genre/deleteGenres.php";
    }
}

?>