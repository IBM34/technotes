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
    <link href="./style.css" rel="stylesheet" type="text/css" />
    <title>Compte</title>
  </head>
  <body>
    <?php include("./headnav.html");?>
    <div id="corps">
    <div id="gauche">
      <div id="titre">
        <center>Mon compte</center>
      </div>
      </br>
      <form action="compte.php?membre=<?php echo $_SESSION["id"]; ?>" method="POST">
      <center>
        <?php
        define ('POSTER_NOTE', 0x01); // Constantes de droits
  		  define ('COMMENTER_NOTE', 0x02); 
		  define ('LIRE_QUESTION', 0x04);
        define ('POSTER_QUESTION', 0x08);
        define ('REPONDRE_QUESTION', 0x010);
        define ('INACTIVER_COMPTE', 0x020);
        define ('SUPPRIMER_COMPTE', 0x040);
        
        if (!((int)$_SESSION['droits'])) //si l'utilisateur n'est pas connecté
  		  {
          echo 'Connectez-vous pour acceder à votre compte!';
        }
        else
        {
        if ($_GET['membre']!=$_SESSION['id']) // si la page de compte n'appartient pas à l'utilisateur connecté
        {
          echo 'Vous ne pouvez pas acceder à cette page';
        }
        else 
        {
        	 $bdd = new PDO('mysql:host=localhost;dbname=technotes;charset=utf8', 'root', 'tony239');
        	 $req = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
          $req->execute(array($_GET['membre']));
          $donnees = $req->fetch();
          //Affichage des informations du membre
          echo 'id: ';
          echo $donnees['id'];
          echo '</br>';
          echo 'id groupe: ';
          echo $donnees['id_groupe'];
			 echo '</br>';
          echo 'pseudo: ';
	       echo $donnees['pseudo'];
	       echo '</br>';
          echo 'statut: ';
	       echo $donnees['statut'];
	       
	       echo '
                  </br></br>
	          <div id="titre2">
                  <center>Modification du mot de passe</center>
                  </div>
		  <p>Ancien mot de passe</p>
		  <input type="password" name="ancienpass">
		  <p>Nouveau mot de passe</p>        
        <input type="password" name="nouveaupass">
        <p>Confirmer le nouveau mot de passe</p>
		  <input type="password" name="confirmpass"></br></br>
        <input type="submit" name="submit" value="Enregistrer">
        ';
        }
        }
        
        //si l'utilisateur a modifié son mot de passe
        
        if(isset($_POST['submit']))
        {
        	  if(isset($_POST['ancienpass'])&& isset($_POST['nouveaupass']) && isset($_POST['confirmpass']))
        	  {
        	  	  // On vérifie que l'ancien mot de passe est correct
          	  $pass_hache = sha1($_POST['ancienpass']);
              $req = $bdd->prepare('SELECT id, statut FROM membres WHERE pseudo = :pseudo AND password = :pass');
              $req->execute(array('pseudo' => $_SESSION["pseudo"],'pass' => $pass_hache));
              $resultat = $req->fetch();  
                 if (!$resultat) //si l'ancien mot de passe et incorrect
                 {
           	        echo '<p style="color:red;">l\'ancien mot de passe est incorrect !</p>';
                 }      
                 else // si l'ancien mot de passe est correct
                 {
                    if($_POST['nouveaupass']==$_POST['confirmpass']) // si les 2 mots de passe correspondent
                    {
                    	  // On remplace l'ancien mot de passe par le nouveau
                    	  $pass_hache = sha1($_POST['nouveaupass']);
				           $req = $bdd->prepare("UPDATE membres SET password=:pass WHERE id=:id");
				           $req->execute(array('pass' => $pass_hache , 'id' => $_SESSION['id']));
				           echo '<p style="color:green;">Changement de mot de passe reussi !</p>';
				                   
                    }
                    else 
                    {
                    	  echo '<p style="color:red;">les 2 mots de passe de correspondent pas !</p>';
                    }
                 }  
           }
        }
		  
		  ?>
      </center>
      </form>
    </div>
    <?php include("./connexionfooter.html");?>
  </body>
</html>
