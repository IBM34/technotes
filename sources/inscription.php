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
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
  <head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="style.css" rel="stylesheet" type="text/css">
    <title>Inscription</title>
  </head>
  <body>
    <?php include("./headnav.html");?>
    <div id="corps">
      <div id="gauche">
        <div id="titre">
          <center>Inscription</center>
        </div>
        <br>
        <?php
          function Genere_Password($size)
          {
              // Initialisation des caractères utilisables
              $characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
          
              for($i=0;$i<$size;$i++)
              {
                  $password .= ($i%2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
              }
          
              return $password;
          }
          $bdd = new PDO('mysql:host=localhost;dbname=technotes;charset=utf8', 'root', 'tony239');
          if (isset($_POST["pseudo"]) && isset($_POST["email"])){
                  $req = $bdd->prepare('SELECT id FROM membres WHERE pseudo = :pseudo');
                  $req->execute(array(
                  'pseudo' => $_POST["pseudo"]));
                  $resultat = $req->fetch();
                  if ($resultat) // vérifie si le pseudo est déja utilisé.
                  {
                  echo 'Pseudo déja utilisé !';
                  }
                  else 
                  {
                          $req = $bdd->prepare('SELECT id FROM membres WHERE email = :email');
                          $req->execute(array(
                          'email' => $_POST["email"]));
                          $resultat = $req->fetch();
                          if ($resultat) // vérifie si le mail est déja utilisé
                          {
                          echo 'email déja utilisé !';
                          }
                          else // Inscription du nouveau membre
                          {
                          $password=Genere_Password(9); // génération d'un mot de passe
                          $pass_hache = sha1($password); // cryptage du mot de passe
                          $id_groupe=2;
                          // Le message
                          $message = "Votre mot de passe: \r\n".$password;
          
                          // Envoi du mail et insertion du membre dans la base de donnée
                                  if (mail($_POST['email'], 'Inscription technotes', $message))
                                  {
                                   $statut="Active";
                                   echo '<center>Vous allez recevoir un email contenant votre mot de passe</center></br>';
                                  $req = $bdd->prepare('INSERT INTO membres(id_groupe,pseudo, email, password,statut) VALUES(:id_groupe,:pseudo, :email, :password, :statut)');
          
                                  $req->execute(array('id_groupe' => $id_groupe,'pseudo' => $_POST['pseudo'],'password' => $pass_hache,'email' => $_POST['email'],'statut' => $statut));
                                  }
                                  else // Non envoyé
                                  {
                                      echo "Le mot de passe n'a pas pu être envoyé a votre email";
                                  }       
                          }
                  }                       
          }       
          ?>
        <center>
        <form action="inscription.php" method="POST">
          <label for="email">Saisissez votre email</label><br>
          <input type="text" name="email"><br>
          <br>
          <label for="pseudo">Saisissez votre pseudo</label><br>
          <input type="text" name="pseudo"><br>
          <br>
          <input type="submit" name="submit" value="Valider"><br>
        </form>				
        </center>
      </div>
      <?php include("./connexionfooter.html");?>
    </div>
  </body>
</html>
