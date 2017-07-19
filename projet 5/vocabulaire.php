<?php
session_start();
?>
<!DOCTYPE html/>
<head>
  <meta charset="utf-8"/>
  <title>Lecture</title>
    <script type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="styles.css" media="all"/>
</head>

<?php
  include_once("navbar.php");
?>

<body>

<?php

try
{
  $bdd = new PDO ('mysql:host=localhost; dbname=ProjetNFA021; charset=utf8', 'root', 'root');
}
catch (Exception $e)
{
  die ('Erreur: '.$e->getMessage());
}

// affichage Titre de chanson
$request=$bdd->prepare('SELECT * FROM chansons WHERE id = ?');
$request->execute(array($_POST['titre']));
while ($dons = $request->fetch())
{
  echo "<h2>".$dons['titre']." - ".$dons['artiste']."</h2><br/><br/>";
}
$request->closeCursor();

// recherche lien du titre
$req=$bdd->prepare('SELECT * FROM paroles WHERE id_chanson = ?');
$req->execute(array($_POST['titre']));
while ($donnees = $req->fetch())
{
  $text=$donnees['txt_francais'];
}


$file= "textes/fr/".$text;
$text=fopen($file, "r");

$recherche=$bdd->prepare('SELECT * FROM vocabulaire WHERE mot_fr = ?');
while (!feof($text)) {
  $ligne=fgets($text);
    $mots=explode(" " , trim($ligne));

      foreach ($mots as $mot) {
        $recherche->execute(array($mot));
        while ($words=$recherche->fetch()) {
          $wrd = strtolower($mot);
          echo "<ul>".$wrd." - - - - - ".$words['traduction_ru']."</ul>";
        }
      }
}
?>

<form method="POST" action="test.php">
  <input type="submit" class="boutton" id="vocasubmit" value="TESTER VOS CONNAISSANCES"></input>
  <input type="hidden" class="boutton" name="titre" value="<?php echo $_POST['titre'];?>"></input>
</form>

</body>
</html>