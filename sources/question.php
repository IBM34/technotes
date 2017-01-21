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
    <title>Question</title>
  </head>
  <body>
    <?php include("./headnav.html");?>
    <div id="corps">
    <div id="gauche">
    <div id="titre">
        <center>Question</center>
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
        // si "marquée comme resolue" alors update bdd 
        if (isset($_POST["resolve"]))
        {

        $req = $bdd->prepare("UPDATE questions SET statut='resolue' WHERE id=:id");
        $req->execute(array('id' => $_GET['question']));
        }
        //Ajout de la reponse potentiellement postée à la bdd
         if (isset($_POST["submitrep"])){
        if (isset($_POST["reponse"])){
        $req = $bdd->prepare('INSERT INTO reponses(id_question, pseudo, reponse, date_reponse) VALUES(:id_question, :pseudo, :reponse, NOW())');
        $req->execute(array('id_question' => $_GET['question'], 'pseudo' => $_SESSION['pseudo'],'reponse' => $_POST['reponse']));
        }
     }
        // Récupération de la question
        $req = $bdd->prepare('SELECT id,pseudo, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr ,statut FROM questions WHERE id = ?');
        $req->execute(array($_GET['question']));
        $donnees = $req->fetch();
        ?>
      <br />
     <div class="news2">  
      
        <b style="font-size:0.7em;">
         Par <?php echo htmlspecialchars($donnees['pseudo']); ?>
          le <?php echo $donnees['date_creation_fr']; ?>
        </b>
        <?php 
        if ($donnees['statut']=="resolue")
        {
        echo '
        <b style="float: right; font-size:0.9em; color: green;">Résolue   </b>
        ';
        }
     
         ?>
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
            echo nl2br(htmlspecialchars($donnees['contenu']));
            ?>
        </p>
      </div>
     <?php
        if ($donnees['statut']!="resolue")
        {
        if ($donnees['pseudo']==$_SESSION['pseudo'])
        {
           ?>
   </br>
   <form action="question.php?question=<?php echo $_GET['question']; ?>" method="POST">
	     <center><input type="submit" name="resolve" value="Marquer comme résolue"></center>
<?php
        }
	}
?>
       </br>
       <div id="titre2">
                  <center>Réponses</center>
       </div>
      <?php
        $req->closeCursor(); //on libère le curseur pour la prochaine requête
        // Récupération des réponses
        $req = $bdd->prepare('SELECT id,pseudo, reponse, DATE_FORMAT(date_reponse, \'%d/%m/%Y à %Hh%i\') AS date_reponse_fr FROM reponses WHERE id_question = ? ORDER BY date_reponse');
        $req->execute(array($_GET['question']));
        $i = 0;
        echo '</br>';
        while ($donnees = $req->fetch())
        { 
        ?>

 <a href="reponse.php?reponse=<?php echo $donnees['id']; ?>">        
 <div class="reponse">  
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
     </a>

     <?php
     
	  
      
       $i=$i+1;
        } // Fin de la boucle des réponses
        if ($i == 0)
        {
        echo '<center><p>Pas de réponses pour le moment</p></center>';
        }
        $req->closeCursor();
        $req->closeCursor();
         define ('POSTER_NOTE', 0x01); // Constantes de droits
  		  define ('COMMENTER_NOTE', 0x02); 
		  define ('LIRE_QUESTION', 0x04);
        define ('POSTER_QUESTION', 0x08);
        define ('REPONDRE_QUESTION', 0x010);
        define ('INACTIVER_COMPTE', 0x020);
        define ('SUPPRIMER_COMPTE', 0x040);
  
  		  if (!((int)$_SESSION['droits'] & REPONDRE_QUESTION)) 
  		  {
          echo '<center>Seuls les membres peuvent répondre à une question !<br /> Connectez vous ou inscrivez-vous</center>';
        }
        else
        {
       ?>
      <form action="question.php?question=<?php echo $_GET['question']; ?>" method="POST">
      <?php
        echo
        '
       </br>
        <div id="titre2">
                 <center>Ajouter une réponse</center>
        </div>	
      </br>
      <center><input type="text" name="reponse" ></center>
      <center><input type="submit" name="submitrep" value="Ajouter"></center>
      ';
   }
   ?>
    </div>

     
    <?php include("./connexionfooter.html");?>
   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="js/search.js"></script>

  </body>
</html>
