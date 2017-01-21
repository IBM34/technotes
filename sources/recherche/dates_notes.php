<?php
$bdd = new PDO('mysql:host=localhost;dbname=technotes;charset=utf8', 'root', 'tony239');


$requete = $bdd->query('SELECT DATE_FORMAT(date_creation, \'%m/%d/%Y\') AS date_creation_fr FROM notes'); 

$array = array(); // on créé le tableau

while($donnee = $requete->fetch()) // on effectue une boucle pour obtenir les données
{
    array_push($array, $donnee['date_creation_fr']); // et on ajoute celles-ci à notre tableau
}
echo json_encode($array); // il n'y a plus qu'à convertir en JSON

?>
