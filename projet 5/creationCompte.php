<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <title> Creation compte </title>
  <link rel="stylesheet" type="text/css" href="styles.css" media="all"/>
</head>

<body>
<div id="overlay3">
    <div class="popup_block">
        <a class="close" href="#noWhere"><img alt="Fermer" title="Fermer la fenêtre" class="btn_close" src="./images/close_pop2.png"></a>
        <h2>Creer un compte</h2>

        <form name="comptecrea" id = "comptecrea" class="comptecreation" method="post" action="artiste.php" onsubmit= "return verifForm()" >
          <input type="text" name="prenom" id="prenom" class="champs" placeholder="prenom"  /><br/><br/>
          <input type="text" name="nom"  id="nom" class="champs" placeholder="nom"  /><br/><br/>
          <input type="text" name="mail" id="mail" class="champs" placeholder="mail" onblur="VerifMail(mail)"/><br/><br/>
          <input type="password" name="mdp" id="mdp" class="champs" placeholder="mot de passe" /><br/><br/>
          <input type="password" name="mdp2" id="mdp2" class="champs" placeholder="confimez votre mot de passe"  /><br/><br/>

         <input type="submit" id="mdpsubmit" value="VALIDER" name="mdpsubmit"/>
        </form>
    </div>
</div>


<script type="text/javascript">

function verifForm() {

    var lastname = document.getElementById('nom').value;
    var surname = document.getElementById('prenom').value;
    var email = document.getElementById('mail').value;
    var pswd = document.getElementById('mdp').value;
    var pswd2 = document.getElementById('mdp2').value;

    if (lastname == "") {
      mess2 = "champs vide";
      document.getElementsByName('nom')[0].placeholder = "champs vide";
      surligne(nom, true);
      return false;
    }
    if (surname == "") {
      mess1 = "champs vide";
      document.getElementsByName('prenom')[0].placeholder = "champs vide";
      surligne(prenom, true);
      return false;
    }
    if (email == "") {
      document.getElementsByName('mail')[0].placeholder = "champs vide";
      surligne(mail, true);
      return false;
    }
    if (pswd == "") {
      document.getElementsByName('mdp')[0].placeholder = "champs vide";
      surligne(pswd, true);
      return false;
    }
    if (pswd2 == "") {
      document.getElementsByName('mdp2')[0].placeholder = "champs vide";
      surligne(pswd2, true);
      return false;
    }

    if (pswd != pswd2) {
      alert ("mots de passes differents");
      return false;
    }

    var mailOk = VerifMail(mail);
    if (mailOk==false) {
      alert ("Veuillez saisir une adresse email valide.");
      return false;
    }

    return true;
}

function surligne(champ, erreur)
{
   if(erreur)
      champ.style.backgroundColor = "#fba";
   else
      champ.style.backgroundColor = "";
}


function VerifMail(champ) {
   var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
   if(!regex.test(champ.value))
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}

</script>

<?php


if (isset($_POST["mdpsubmit"])) {
    try
  {
    $bdd = new PDO ('mysql:host=localhost; dbname=ProjetNFA021; charset=utf8', 'root', 'root');
  }
  catch (Exception $e)
  {
    die ('Erreur: '.$e->getMessage());
  }

  $request = $bdd->prepare('SELECT * FROM utilisateurs WHERE mail = ?');
  $request->execute(array($_POST['mail']));
  $i=0;
  while ($reponse = $request->fetch()) {
    $i++;
  }

  if ($i==1) {
    echo"<script language=\"javascript\">";
    echo"alert('Un comte associé à cette adresse exixte déjà.')";
    echo"</script>";
  } elseif ($i>1) {
    echo"<script language=\"javascript\">";
    echo"alert('ERREUR BDD. Plusieurs comptes sont associés à cette adresse mail.')";
    echo"</script>";
  } else {
      $_SESSION['prenom'] = $_POST['prenom'];
      $_SESSION['mail'] = $_POST['mail'];
  }

  $req = $bdd->prepare ('INSERT INTO utilisateurs (nom, prenom, mail, password) VALUES (?, ?, ?, ?)');
  $req->execute(array($_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['mdp']));
  $req->closeCursor();
  $_SESSION['mail'] = $_POST['mail'];

}

?>


</body>
</html>