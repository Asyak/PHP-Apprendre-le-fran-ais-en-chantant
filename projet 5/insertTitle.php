<?php

try
{
  $bdd = new PDO ('mysql:host=localhost; dbname=ProjetNFA021; charset=utf8', 'root', 'root');
}
catch (Exception $e)
{
  die ('Erreur: '.$e->getMessage());
}

//insertion Artiste
if (isset($_POST["insererArtiste"])) {
  $req = $bdd->prepare ('INSERT INTO artistes (artiste) VALUES (?)');
  $req->execute(array($_POST['nom_artiste']));
  $req->closeCursor();
}

// insertion Titre
if (isset($_POST["insererTitle"])) {
  $req = $bdd->prepare ('INSERT INTO chansons (id_artiste, titre, artiste, lien) VALUES (?, ?, ?, ?)');
  $req->execute(array($_POST['id_artiste'], $_POST['titre'], $_POST['artiste'], $_POST['lien']));
  $req->closeCursor();
}

// insertion Paroles
if (isset($_POST["insererParoles"])) {
  $req = $bdd->prepare ('INSERT INTO paroles (id_chanson, artiste, txt_francais, txt_russe)
    VALUES (?, ?, ?, ?)');
  $req->execute(array($_POST['id_titre'], $_POST['nom_artiste'], $_POST['parolesFR'],
    $_POST['parolesRU']));
  $req->closeCursor();

// insertion vocabulaire
  $request = $bdd->prepare('INSERT INTO vocabulaire(mot_fr)
    VALUES (?)');
  $file= "textes/fr/".$_POST['parolesFR'];
  $text=fopen($file, "r");

   while (!feof($text)){
      $ligne=fgets($text);
      $mots=explode(" " , trim($ligne));
      foreach ($mots as $mot) {
        $request->execute(array($mot));
      }
  }
  $request->closeCursor();
}

header('Location: insertTitleForm.php');

?>