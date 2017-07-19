<?php
header("Content-Type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
echo "<list>";

// $artiste = (isset($_POST["artiste"])) ? htmlentities($_POST["artiste"]) : NULL;


if (isset($_POST["artiste"]) && $_POST["artiste"] != "first") {
  $bdd = new PDO ('mysql:host=localhost; dbname=ProjetNFA021; charset=utf8', 'root', 'root');
  $query = $bdd->prepare('SELECT * FROM chansons WHERE artiste=? ORDER BY titre');
  $query->execute(array($_POST["artiste"]));
    while ($back = $query->fetch()) {
      echo "<item id=\"" . $back["id"] . "\" titre= \"" . $back["titre"] . "\" />";
    }
  $query->closeCursor();
}

if (isset($_POST["artiste"]) && $_POST["artiste"] == "first") {
$bdd = new PDO ('mysql:host=localhost; dbname=ProjetNFA021; charset=utf8', 'root', 'root');
$reponse = $bdd->query('SELECT * FROM chansons ORDER BY titre');
  while ($back = $reponse->fetch()) {
    echo "<item id=\"" . $back["id"] . "\" titre= \"" . $back["titre"] . "\" />";
  }

}



echo "</list>";



?>