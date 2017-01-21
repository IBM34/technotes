<<?php 
session_start(); 
include("./connexion.php");
if (isset($_POST['deconnexion']))
        	{
        	session_destroy();	
        	$_SESSION = array(); 
        	unset($_SESSION);
        }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Nouvelle question</title>
  </head>
  <body>
    <?php include("./headnav.html");?>
    <div id="corps">
    <div id="gauche">
      <div id="titre">
        <center>Poster une question</center>
      </div>
      </br>
      <?php 
        $bdd = new PDO('mysql:host=localhost;dbname=technotes;charset=utf8', 'root', 'tony239');
        $statut="irresolue";
        if (isset($_POST["titre"]) && isset($_POST["contenu"])){ // Insertion de la question et des mots_clès
        $req = $bdd->prepare('INSERT INTO questions(pseudo, titre, contenu, date_creation, statut) VALUES(:pseudo, :titre, :contenu, NOW(), :statut)');
        $req->execute(array('pseudo' => $_SESSION['pseudo'],'titre' => $_POST['titre'],'contenu' => $_POST['contenu'], 'statut' => $statut));        $req = $bdd->query('SELECT id FROM questions WHERE id=(SELECT MAX(id) FROM questions)'); 
        $id = $req->fetch();
        $mots = explode(";", $_POST['mots']);
        $req = $bdd->prepare('INSERT INTO mots_cles(id_question, mot) VALUES(:id, :mot)');
		  foreach($mots as $mot)
		    {
            $req->execute(array('id' => $id['id'],'mot' => $mot));
          }       
        }
        define ('POSTER_NOTE', 0x01); // Constantes de droits
  		  define ('COMMENTER_NOTE', 0x02); 
		  define ('LIRE_QUESTION', 0x04);
        define ('POSTER_QUESTION', 0x08);
        define ('REPONDRE_QUESTION', 0x010);
        define ('INACTIVER_COMPTE', 0x020);
        define ('SUPPRIMER_COMPTE', 0x040);
  
  		  if (!((int)$_SESSION['droits'] & POSTER_QUESTION)) //Vérification de connexion et de droits
  		  {
          echo 'Seul les membres peuvent poster une question !<br /> Connectez vous ou inscrivez-vous';
        }
        else
        {
        	echo '
      <form action="newquestion.php" method="POST">
        <center><label for="titre">Titre</label></center>
        <center><input type="text" name="titre" required></center>
        </br>
        <center><label for="contenu">Texte</label></center>
        <center><textarea name="contenu" rows=10 COLS=80></textarea></center>
        </br>
        <center><label for="contenu">Mots_clés (séparés par ";")</label></center>
        <center><input type="text" name="mots"></center>
		  </br>
        <center><input type="submit" name="submit" value="Ajouter"></center>
      </form>
      ';
   }
   ?>
    </div>
    <?php include("./connexionfooter.html");?>
  </body>
</html>
