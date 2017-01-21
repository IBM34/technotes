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
    <title>Réponse</title>
  </head>
  <body>
    <?php include("./headnav.html");?>
    <div id="corps">
    <div id="gauche">
    <div id="titre">
        <center>Réponse</center>
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
        //Ajout du commentaire potentiellement postée à la bdd
        if (isset($_POST["submitcom"])){
        if (isset($_POST["commentaire"])){
        $req = $bdd->prepare('INSERT INTO commentaires(id_reponse, pseudo, commentaire, date_commentaire) VALUES(:id_reponse, :pseudo, :commentaire, NOW())');
        $req->execute(array('id_reponse' => $_GET['reponse'], 'pseudo' => $_SESSION['pseudo'],'commentaire' => $_POST['commentaire']));
        }
     }
        // Récupération de la réponse
        $req = $bdd->prepare('SELECT id,pseudo, reponse, DATE_FORMAT(date_reponse, \'%d/%m/%Y à %Hh%i\') AS date_reponse_fr FROM reponses WHERE id = ? ORDER BY date_reponse');
        $req->execute(array($_GET['reponse']));
        $donnees = $req->fetch();
 ?>
        </br>
       <div class="news2">  
        <b style="font-size:0.7em;">
         Par <?php echo htmlspecialchars($donnees['pseudo']); ?>
          le <?php echo $donnees['date_reponse_fr']; ?>
        </b>
        <hr/>
        <p>
          <?php
            echo nl2br(htmlspecialchars($donnees['reponse']));
            ?>
        </p>
      </div>
     </br>
       
     
       <div id="titre2">
                  <center>Commentaires</center>
        </div>
      <?php
        $req->closeCursor(); // on libère le curseur pour la prochaine requête
        // Récupération des commentaires
        $req = $bdd->prepare('SELECT pseudo, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %Hh%i\') AS date_commentaire_fr FROM commentaires WHERE id_reponse = ? ORDER BY date_commentaire');
        $req->execute(array($_GET['reponse']));
        $i=0;
        echo '</br>';
        while ($donnees = $req->fetch())
        {
        ?>
   
 <div class="news2">  
        <b style="font-size:0.7em;">
         Par <?php echo htmlspecialchars($donnees['pseudo']); ?>
          le <?php echo $donnees['date_commentaire_fr']; ?>
        </b>
        <hr/>
        <p>
          <?php
            echo nl2br(htmlspecialchars($donnees['commentaire']));
            ?>
        </p>
      </div>
     </br>
     
      <?php
        $i=$i+1;
        } // Fin de la boucle des commentaires
        if ($i == 0)
        {
        echo '<center><p>Pas de commentaires pour le moment</p></center>';
        }
        $req->closeCursor();
      
        define ('POSTER_NOTE', 0x01); // Constantes de droits
        define ('COMMENTER_NOTE', 0x02); 
	define ('LIRE_QUESTION', 0x04);
        define ('POSTER_QUESTION', 0x08);
        define ('REPONDRE_QUESTION', 0x010);
        define ('INACTIVER_COMPTE', 0x020);
        define ('SUPPRIMER_COMPTE', 0x040);
  
  		  if (!((int)$_SESSION['droits'] & COMMENTER_NOTE)) 
  		  {
          echo '<center>Seuls les membres peuvent commenter une réponse !<br /> Connectez vous ou inscrivez-vous</center>';
        }
        else
        {
        ?>
      <form action="reponse.php?reponse=<?php echo $_GET["reponse"]; ?>" method="POST">
      <?php
      	echo
        '
        </br>
        <div id="titre2">
                 <center>Ajouter un commentaire</center>
        </div>	
     
      </br>
      <center><input type="text" name="commentaire"></center>
      <center><input type="submit" name="submitcom" value="Ajouter"></center>
      ';
      
   }
   ?>
      
      
    </div>
    <?php include("./connexionfooter.html");?>
  </body>
</html>
