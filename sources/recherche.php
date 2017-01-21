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
    <link rel="stylesheet" href="./jquery-ui.css">
    <title>Recherche</title>
  </head>
  <body>
    <?php include("./headnav.html");?>
    <div id="corps">
    <div id="gauche">
      <div id="titre">
        <center>Recherche</center>
      </div>
<form action="recherche.php" method="POST">
<center>

<div id="radio_left"><!-- Boutons de recherche d'une note -->
<br />
<label><input type="radio" name="type" value="note" onclick="check();" checked/>rechercher une note</label><br />
<br />
<label><input type="radio" name="methode_recherche_note" value="mots_cles" onclick="check_mots_note();" checked />mots_clés</label><br />
<label><input type="radio" name="methode_recherche_note" value="auteur" onclick="check_auteurs_note();"/>auteur</label><br />
<label><input type="radio" name="methode_recherche_note" value="date" onclick="check_datepicker_notes();"/>date</label>
<br />
<br />
</div>
<div id="radio_right"> <!--Boutons de recherche d'une question --> 
<br />
<label><input type="radio" name="type" value="question" onclick="check();"/>rechercher une question</label><br />
<br />
<label><input type="radio" name="methode_recherche_question" value="mots_cles" onclick="check_mots_question();" disabled/>mots_clés</label><br />
<label><input type="radio" name="methode_recherche_question" value="statut" onclick="check_statut_questions();" disabled/>statut</label><br />
<label><input type="radio" name="methode_recherche_question" value="date" onclick="check_datepicker_questions();" disabled/>date</label>
<br />
<br />
</div>

<!-- Différents "input" de texte qui s'affichent ou ne s'affichent pas en fonction des choix de recherche -->
<input type="text" placeholder="Entrez les mots_clès de la note" name="recherche_mots_note" id="recherche_mots_note"/>
<input type="text" placeholder="Entrez les mots_clès de la question" name="recherche_mots_question"  id="recherche_mots_question" hidden/>
<input type="text" placeholder="Entrez un auteur de note" name="recherche_auteurs_note" id="recherche_auteurs_note" hidden/>
<input type="text" placeholder="Entrez une date de note" id="datepicker_notes" name="datepicker_notes"  hidden>
<input type="text" placeholder="Entrez une date de question" id="datepicker_questions" name="datepicker_questions" hidden>
<select name="statut" id="statut" hidden>
  <option value="resolue" >résolue</option>
  <option value="irresolue">non résolue</option>
</select> 
<input type="submit" name="submit" value="rechercher" />

</br></br>

</form>


<?php

$bdd = new PDO('mysql:host=localhost;dbname=technotes;charset=utf8', 'root', 'tony239');


    if($_POST['type']=='note') // si recherche de note
    {
        if($_POST['methode_recherche_note']=='mots_cles') //si recherche par mots_clès
        {        
	  $req = $bdd->prepare('SELECT notes.id, pseudo, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr FROM notes,mots_cles WHERE mots_cles.mot LIKE :mot AND mots_cles.id_note=notes.id ORDER BY date_creation');
          $req->execute(array('mot' => $_POST['recherche_mots_note']));
        }
        if($_POST['methode_recherche_note']=='auteur') // si recherche par auteur
        {
          $req = $bdd->prepare('SELECT notes.id, pseudo, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr FROM notes WHERE pseudo=:pseudo ORDER BY date_creation');
          $req->execute(array('pseudo' => $_POST['recherche_auteurs_note']));
        }
        if($_POST['methode_recherche_note']=='date') // si recherche par date
        {
          $req = $bdd->prepare('SELECT notes.id, pseudo, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr FROM notes WHERE DATE_FORMAT(date_creation, \'%d/%m/%Y \')=:date ORDER BY date_creation');
          $req->execute(array('date' => $_POST['datepicker_notes']));
        }
     ?>

     
  <div id="titre2">
        <center>Notes</center>
      </div>
    
</center>

<!-- Affichage des notes qui correspondent à la recherche -->

<?php

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
        echo '</br>';
        $req->closeCursor();
        
    }
    
    if($_POST['type']=='question') // Si recherche d'une question
    {
        if($_POST['methode_recherche_question']=='mots_cles') //si recherche par mots_clès
        {
          $req = $bdd->prepare('SELECT questions.id, pseudo, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr , statut FROM questions,mots_cles WHERE mots_cles.mot LIKE :mot AND mots_cles.id_question=questions.id ORDER BY date_creation');
          $req->execute(array('mot' => $_POST['recherche_mots_question']));
        }
        if($_POST['methode_recherche_question']=='statut')// si recherche par statut
        {
        $req = $bdd->prepare('SELECT questions.id, pseudo, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr , statut FROM questions WHERE statut=:statut ORDER BY date_creation');
          $req->execute(array('statut' => $_POST['statut']));
        }
        if($_POST['methode_recherche_question']=='date')// si recherche par date
        {
         $req = $bdd->prepare('SELECT questions.id, pseudo, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr, statut FROM questions WHERE DATE_FORMAT(date_creation, \'%d/%m/%Y \')=:date ORDER BY date_creation');
          $req->execute(array('date' => $_POST['datepicker_questions']));
        }    
          ?>

     
  <div id="titre2">
        <center>Questions</center>
      </div>
    
</center>

<!-- Affichage des questions qui correspondent à la recherche -->

<?php

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
        echo '</br>';
        $req->closeCursor();
    }
?>



    </div>
    <?php include("./connexionfooter.html");?>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="js/search.js"></script>
  </body>
</html>
