<?php
ob_start();
// démarre la temporisation de sortie
?>


<h2>Ceci est une page d'accueil</h2>



<?php

$title = "Allocine "; 
$content = ob_get_clean();
require "views/template.php"
?>