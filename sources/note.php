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
    <title>Note</title>
  </head>
  <body>
    <?php include("./headnav.html");?>
    <div id="corps">
    <div id="gauche">
    <div id="titre">
        <center>Note</center>
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
        $req = $bdd->prepare('INSERT INTO commentaires(id_note, pseudo, commentaire, date_commentaire) VALUES(:id_note, :pseudo, :commentaire, NOW())');
        $req->execute(array('id_note' => $_GET['note'], 'pseudo' => $_SESSION['pseudo'],'commentaire' => $_POST['commentaire']));
        }
     }
        // Récupération de la note
        $req = $bdd->prepare('SELECT id,pseudo, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr FROM notes WHERE id = ?');
        $req->execute(array($_GET['note']));
        $donnees = $req->fetch();
        
        $donnees['contenu'] = stripslashes($donnees['contenu']);
        $texte = $donnees['contenu'];
        $texte = nl2br(htmlentities($texte));
        $entree = array('#\[code\](.*)\[/code\]#Usi');
        $sortie = array('<div id="code"><div id="titre3"><center>Code</center></div>$1</div>');
        $texte = preg_replace($entree[0],$sortie[0],$texte);

        ?>
     <br />
     <div class="news2">  
        <b style="font-size:0.7em;">
         Par <?php echo htmlspecialchars($donnees['pseudo']); ?>
          le <?php echo $donnees['date_creation_fr']; ?>
        </b>
        <hr/>
        <center>
        <b>
          <?php
            // On affiche le titre de la note 
            echo nl2br(htmlspecialchars($donnees['titre']));
            ?>
          <br />
        </b>
        </center>
       <p>
          <?php
            echo $texte;
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
        $req = $bdd->prepare('SELECT pseudo, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %Hh%i\') AS date_commentaire_fr FROM commentaires WHERE id_note = ? ORDER BY date_commentaire');
        $req->execute(array($_GET['note']));
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
          echo '<center>Seuls les membres peuvent commenter une note !<br /> Connectez vous ou inscrivez-vous</center>';
        }
        else
        {
        ?>
      <form action="note.php?note=<?php echo $_GET["note"]; ?>" method="POST">
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
