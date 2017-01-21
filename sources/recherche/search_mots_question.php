<?php
$bdd = new PDO('mysql:host=localhost;dbname=technotes;charset=utf8', 'root', 'tony239');

$term = $_GET['term'];

$requete = $bdd->prepare('SELECT * FROM mots_cles WHERE mot LIKE :term AND id_question<>"0"'); // j'effectue ma requête SQL grâce au mot-clé LIKE

$requete->execute(array('term' => $term.'%'));

$array = array(); // on créé le tableau

while($donnee = $requete->fetch()) // on effectue une boucle pour obtenir les données
{
    array_push($array, $donnee['mot']); // et on ajoute celles-ci à notre tableau
}
echo json_encode($array); // il n'y a plus qu'à convertir en JSON

?>
