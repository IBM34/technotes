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
    <title>Forum</title>
  </head>
  <body>
    <?php include("./headnav.html");?>
    <div id="corps">
    <div id="gauche">
      <div id="titre">
        <center>Questions</center>
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
        define ('POSTER_NOTE', 0x01); // Constantes de droits
  		  define ('COMMENTER_NOTE', 0x02); 
		  define ('LIRE_QUESTION', 0x04);
        define ('POSTER_QUESTION', 0x08);
        define ('REPONDRE_QUESTION', 0x010);
        define ('INACTIVER_COMPTE', 0x020);
        define ('SUPPRIMER_COMPTE', 0x040);
  
  		  if (!((int)$_SESSION['droits'] & LIRE_QUESTION))  //vérification de connexion 
  		  {
          echo '<center>Seuls les membres peuvent acceder au forum !<br /> Connectez vous ou inscrivez-vous</center>';
        }
        else
        {
        // On récupère les 5 dernieres questions
        $req = $bdd->query('SELECT id,pseudo, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr ,statut FROM questions ORDER BY date_creation DESC LIMIT 0, 5');
        
        while ($donnees = $req->fetch())
        {
        ?>
        <br/>
      <a href="question.php?question=<?php echo $donnees['id']; ?>">
      <div class="news">
        <b style="font-size:0.7em;">
          Par <?php echo htmlspecialchars($donnees['pseudo']); ?>
          le <?php echo $donnees['date_creation_fr']; ?>
        </b>
         <?php 
        if ($donnees['statut']=="resolue")
        echo '
        <b style="float: right; font-size:0.9em; color: green;">Résolue   </b>
        ';
         ?>
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
        } // Fin de la boucle des questions
        $req->closeCursor();
     		}
        ?>
        <br/>
    </div>
    <?php include("./connexionfooter.html");?>
  </body>
</html>
