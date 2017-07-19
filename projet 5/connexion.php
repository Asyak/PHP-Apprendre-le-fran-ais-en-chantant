<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <title> Connexion </title>
  <link rel="stylesheet" type="text/css" href="styles.css" media="all"/>
</head>


<body>

<div id="overlay2">
    <div class="popup_window">
        <a class="fermer" href="#noWhere"><img alt="Fermer" title="Fermer la fenêtre" class="btn_fermer" src="./images/close_pop2.png"></a>
        <h2>Connexion</h2>

        <form name="connexion" id = "connexion" class="connexion" method="post" action="artiste.php">
          <input type="text" name="mail2" id="mail2" class="champs" placeholder="mail"/><br/><br/>
          <input type="password" name="mp" id="mp" class="champs" placeholder="mot de passe" /><br/><br/>
          <input type="submit" id="mpsubmit" value="VALIDER" name="mpsubmit"/>
        </form>
    </div>
</div>


<?php

if (isset($_POST['mpsubmit'])) {

  $bdd = new PDO ('mysql:host=localhost; dbname=ProjetNFA021; charset=utf8', 'root', 'root');

  $requete = $bdd->prepare('SELECT * FROM utilisateurs WHERE mail = ?');
  $requete->execute(array($_POST['mail2']));
  $donnees = $requete->fetch();

  if(!$donnees) {
    echo"<script language=\"javascript\">";
    echo"alert('Utilisateur inconnu')";
    echo"</script>";
  }

  if ($donnees['mail'] == $_POST['mail2']) {
    if($donnees['password'] == $_POST['mp']) {
        $_SESSION['prenom'] = $donnees['prenom'];
        $_SESSION['mail'] = $donnees['mail'];
    } else {
        echo"<script language=\"javascript\">";
        echo"alert('Mot de passe incorrect')";
        echo"</script>";
    }
  }
  $requete->closeCursor();
}
?>


</body>
</html>