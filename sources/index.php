<?php 
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
    <title>Technotes</title>
  </head>
  <body>
    <?php include("./headnav.html");?>
    <div id="corps">
    <div id="gauche">
      <div id="titre">
        <center>Notes</center>
      </div>
      <?php
        // Connexion à la base de données
        
        try
        {
        	$bdd = new PDO('mysql:host=localhost;dbname=technotes;charset=utf8', 'root', 'tony239');
        }
        catch(Exception $e)
        {
        		      die('Erreur : '.$e->getMessage());
        }
        
        // On récupère les 5 dernieres notes
        $req = $bdd->query('SELECT id,pseudo, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr FROM notes ORDER BY date_creation DESC LIMIT 0, 5');
         
        while ($donnees = $req->fetch())
        {
        ?>
         <br/>
         <a href="note.php?note=<?php echo $donnees['id']; ?>">
      <div class="news">  
        <b style="font-size:0.7em;">
         Par <?php echo htmlspecialchars($donnees['pseudo']); ?>
          le <?php echo $donnees['date_creation_fr']; ?>
        </b>
        <hr/>
        <p>
          <?php
            // On affiche le titre de la note 
            echo nl2br(htmlspecialchars($donnees['titre']));
            ?>
          <br />
        </p>
      </div>
      </a>
      <?php
        } // Fin de la boucle des notes
        $req->closeCursor();
        ?>
     <br/>
    </div>
    <?php include("./connexionfooter.html");?>
  </body>
</html>
