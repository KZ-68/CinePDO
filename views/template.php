<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <header>
        <h1 id="kzcine">KZCine</h1>
        <nav class="nav_top">
            <ul>
                <li><a class="liTop" href="index.php?action=homepage">Home</a></li>
                <li><a class="liTop" href="index.php?action=listFilms">Movies List</a></li>
                <li><a class="liTop" href="index.php?action=listActors">Actors List</a></li>
                <li><a class="liTop" href="index.php?action=listDirectors">Directors List</a></li>
                <li><a class="liTop" href="index.php?action=listGenres">Genres List</a></li>
                <li><a class="liTop" href="index.php?action=listRoles">Roles List</a></li>
                <li><a class="liTop" href="index.php?action=listPersons">Persons List</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="content_wrapper">
            <div class="flash">
            <?php
                if(isset($_SESSION['flash_message'])) {
                    $message = $_SESSION['flash_message'];
                    echo $message;
                    unset($_SESSION['flash_message']);
                }
            ?>
            </div>
            <?= $content ?>
        </div>
    </main>

    <footer>
        <div class="footer_container">
            <nav>
                <ul>
                    <li><a class="footer_nav" href="#">ABOUT</a></li>
                    <li><a class="footer_nav" href="#">TERMS & CONDITIONS</a></li>
                    <li><a class="footer_nav" href="#">CONTACT</a></li>
                </ul>
            </nav>
            <h3 id="footer_title">KZCine</h3>
            <small>Copyright Kevin ZITNIK</small>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>