<?php

// je demande l'accès au fichier physique soit j'utilise un autoloader
require_once "controllers/HomeController.php";
require_once "controllers/PersonController.php";
require_once "controllers/MovieController.php";
require_once "controllers/GenreController.php";
require_once "controllers/RoleController.php";
require_once "controllers/AppartenirController.php";

// je crée des instances des controlleurs

$homeCtrl = new HomeController();
$personCtrl = new PersonController();
$filmCtrl = new MovieController();
$genreCtrl = new GenreController();
$roleCtrl = new RoleController();
$appartenirCtrl = new AppartenirController();

// l'index va intercepter la requête HTTP et vas orienter vers le bon controlleur et la bonne méthode

// ex: index.php?action=listFilms

if(isset($_GET['action'])) {

    // $id = filter_input(INPUT_GET,'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = filter_input(INPUT_GET,'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id2 = filter_input(INPUT_GET,'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    switch($_GET['action']) {
        // listes
        case "listFilms": $filmCtrl->findAllFilms(); break;
        case "listPersons": $personCtrl->findAllPersons(); break;
        case "listActors": $personCtrl->findAllActors(); break;
        case "listDirectors": $personCtrl->findAllDirectors(); break;
        case "listGenres": $genreCtrl->findAllGenres(); break;
        case "listRoles": $roleCtrl->findAllRoles(); break;
        // détails
        case "detailFilm": $filmCtrl->findOneFilm($id); break;
        case "detailActor": $personCtrl->findOneActor($id); break;
        case "detailDirector": $personCtrl->findOneDirector($id); break;
        case "detailGenre": $genreCtrl->findOneGenre($id); break;
        case "detailRole": $roleCtrl->findOneRole($id); break;
        // formulaire
        case "filmsForm": $filmCtrl->openFilmsForm(); break;
        case "genresForm": $genreCtrl->openGenresForm(); break;
        case "rolesForm": $roleCtrl->openRolesForm(); break;
        case "personsForm": $personCtrl->openPersonsForm(); break;
        // add
        case "addGenres": $genreCtrl->addGenres(); break;
        case "addFilms": $filmCtrl->addFilms($_POST); break;
        case "addCastings": $filmCtrl->addCastings($id); break; 
        case "addPersons": $personCtrl->addPersons($_POST); break;
        case "addActors": $personCtrl->addActors(); break;
        case "addDirectors": $personCtrl->addDirectors(); break;
        case "addRoles": $roleCtrl->addRoles(); break;
        // modify
        case "updateFilms": $filmCtrl->updateFilms($id, $_POST); break;
        case "updateActors": $personCtrl->updateActors($id); break;
        case "updateDirectors": $personCtrl->updateDirectors($id); break;
        case "updateRoles": $roleCtrl->updateRoles($id); break;
        case "updateGenres": $genreCtrl->updateGenres($id); break;
        // delete
        case "deleteFilms": $filmCtrl->deleteFilms(); break;
        case "deleteGenres": $genreCtrl->deleteGenres(); break;
        case "deleteActors": $personCtrl->deleteActors(); break;
        case "deleteDirectors": $personCtrl->deleteDirectors(); break;
        case "deleteRoles": $roleCtrl->deleteRoles(); break;
        // défaut
        default:
            $homeCtrl->homePage();
    }
} else {

    $homeCtrl->homePage();
}

?>