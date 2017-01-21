<?php 
        $bdd = new PDO('mysql:host=localhost;dbname=technotes;charset=utf8', 'root', 'tony239');
        // Hachage du mot de passe
        if (isset($_POST["pseudo"]) && isset($_POST["pass"])){
        $pass_hache = sha1($_POST['pass']);
        // Vérification des identifiants
        $req = $bdd->prepare('SELECT id,statut FROM membres WHERE pseudo = :pseudo AND password = :pass');
        $req->execute(array(
           	'pseudo' => $_POST["pseudo"],
           	'pass' => $pass_hache));
        $resultat = $req->fetch();
        if ($resultat)
        {	
         if($resultat['statut']!='Inactive')
         {	     
         // Attribution des données de session
         $_SESSION['id'] = $resultat['id'];
         $_SESSION['pseudo'] = $_POST["pseudo"];	
         $req = $bdd->prepare('SELECT groupe.actions FROM groupe, membres WHERE membres.pseudo = :pseudo AND groupe.id = membres.id_groupe');
         $req->execute(array('pseudo' => $_POST["pseudo"]));
         $donnees = $req->fetch();
         $_SESSION['droits'] = addslashes($donnees['actions']);
         }
        }
        }
?>