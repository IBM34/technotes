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
    <title>Administration</title>
  </head>
  <body>
    <?php include("./headnav.html");?>
    <div id="corps">
    <div id="gauche">
      <div id="titre">
        <center>Administration</center>
      </div>
      <form action="administration.php" method="GET">
      <center>
        <?php
        define ('POSTER_NOTE', 0x01); // Constantes de droits
  		  define ('COMMENTER_NOTE', 0x02); 
		  define ('LIRE_QUESTION', 0x04);
        define ('POSTER_QUESTION', 0x08);
        define ('REPONDRE_QUESTION', 0x010);
        define ('INACTIVER_COMPTE', 0x020);
        define ('SUPPRIMER_COMPTE', 0x040);
        
        if (!((int)$_SESSION['droits'] & INACTIVER_COMPTE)) 
  		  {
          echo 'Seuls les administrateurs peuvent acceder à cette page !';
        }
        else
        {
        
        if (isset($_GET['Inactiver']))
        {
		     if(isset($_GET['membres'])) //inactivation des membres
		     {
				 foreach($_GET['membres'] as $id)
					{	
					 $bdd =  new PDO('mysql:host=localhost;dbname=technotes;charset=utf8', 'root', 'tony239'); 
					 $req = $bdd->prepare("UPDATE membres SET statut='Inactive' WHERE id=:id");
					 $req->execute(array('id' => $id));
					}
				 
		     }
        }
		  if (isset($_GET['Activer'])) // Activation des membres
        {
		     if(isset($_GET['membres']))
		     {
				 foreach($_GET['membres'] as $id)
					{	
					 $bdd =  new PDO('mysql:host=localhost;dbname=technotes;charset=utf8', 'root', 'tony239'); 
					 $req = $bdd->prepare("UPDATE membres SET statut='Active' WHERE id=:id");
					 $req->execute(array('id' => $id));
					}
				 
		     }
        }
        if (isset($_GET['Supprimer'])) // Suppression des membres
        {
		     if(isset($_GET['membres']))
		     {
				 foreach($_GET['membres'] as $id)
					{	
					 $bdd =  new PDO('mysql:host=localhost;dbname=technotes;charset=utf8', 'root', 'tony239'); 
					 $req = $bdd->prepare("DELETE FROM membres WHERE id =  :id");
					 $req->execute(array('id' => $id));
					}
				 
		     }
        }
$pdo =  new PDO('mysql:host=localhost;dbname=technotes;charset=utf8', 'root', 'tony239');
$query="SELECT * FROM membres WHERE id_groupe<>'1';";
echo '<br/>';
echo '<select name="membres[]" multiple>';
foreach(($pdo->query($query)) as $membres) // Affichage des membres
{
echo "<option value='{$membres['id']}'>";echo "{$membres['pseudo']}";
}
echo "</select>";
echo '
<br/>
<br/>
<input type="submit" name="Inactiver" value="Inactiver">
<br/>
<input type="submit" name="Activer" value="Activer"><br/>
<input type="submit" name="Supprimer" value="Supprimer">';
}
?>
      </center>
      </form>
    </div>
    <?php include("./connexionfooter.html");?>
  </body>
</html>
