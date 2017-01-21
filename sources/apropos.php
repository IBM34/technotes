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
    <title>A propos</title>
  </head>
  <body>
    <?php include("./headnav.html");?>
    <div id="corps">
    <div id="gauche">
      <div id="titre">
        <center>A propos</center>
      </div>
      <center>
        <p>n°Etudiant : 20123477</p>
        <p>NNE: 2505042085G</p>
        <p>Groupe : L3 Informatique C
        <p>Nom et Prénom : Ivan BRUNET-MANQUAT </p>
        <p>Email : ivan.brunet-manquat@etu.umontpellier.fr</p>
      </center>
    </div>
    <?php include("./connexionfooter.html");?>
  </body>
</html>
