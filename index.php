<?php

// je demande l'accès au fichier physique soit j'utilise un autoloader
require_once "controllers/HomeController.php";
require_once "controllers/PersonController.php";
require_once "controllers/MovieController.php";
require_once "controllers/GenreController.php";
require_once "controllers/RoleController.php";

// je crée des instances des controlleurs

$homeCtrl = new HomeController();
$personCtrl = PersonController::getInstance();
// $filmCtrl = new MovieController();
$filmCtrl = MovieController::getInstance();
$genreCtrl = GenreController::getInstance();
$roleCtrl = RoleController::getinstance();

// l'index va intercepter la requête HTTP et vas orienter vers le bon controlleur et la bonne méthode

// ex: index.php?action=listFilms

if(isset($_GET['action'])) {

    // $id = filter_input(INPUT_GET,'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = filter_input(INPUT_GET,'id', FILTER_SANITIZE_NUMBER_INT);

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
        // défaut
        default:
            $homeCtrl->homePage();
    }
} else {

    $homeCtrl->homePage();
}

// if(isset($_GET['action']) && ($_GET['id'])) {
//     switch($_GET['action'] && $_GET['id']) {
//         case "detailFilm": $filmCtrl->findOneFilm(); break;
//     }
// }
?>