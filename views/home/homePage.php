<?php
ob_start();
// démarre la temporisation de sortie
?>

<div class="home_image_container">
<h2 id="h2_home">KZCine Home Page</h2>
    <figcaption class="caption_home">
        <img id="img_home" src="https://wallpaperaccess.com/full/329583.jpg"> 
    </figcaption>
</div>

<section id="home_section1">
<h3 id="h3_home">Movies of the week</h3>
<div class='movieWeek_wrapper'>
<?php
while ($film = $films->fetch()) {

    echo "<div class='movieWeek'>";
?>
    <a href="index.php?action=detailFilm&id=<?=$film['id_film']?>">
        <!-- <p>Detail Film</p> -->
        <h3><?= $film["affiche_film"] ?></h3>
    </a>
    </div>

<?php
}
?>
</div> 
</section>

<?php

$title = "Allocine "; 
$content = ob_get_clean();
require "views/template.php"
?>