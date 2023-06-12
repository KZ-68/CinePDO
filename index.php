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
        // add
        case "addFilms": $filmCtrl->addFilms(); break;
        case "addPersons": $personCtrl->addPersons(); break;
        case "addActors": $personCtrl->addActors(); break;
        case "addDirectors": $personCtrl->addDirectors(); break;
        case "addGenres": $genreCtrl->addGenres(); break;
        case "addAppartenir": $appartenirCtrl->addAppartenir(); break;
        case "addRoles": $roleCtrl->addRoles(); break;
        // modify
        case "modifyFilms": $filmCtrl->modifyFilms($id, $id2); break;
        // delete
        case "deleteFilms": $filmCtrl->deleteFilms(); break;
        case "deleteGenres": $genreCtrl->deleteGenres(); break;
        // défaut
        default:
            $homeCtrl->homePage();
    }
} else {

    $homeCtrl->homePage();
}

?>