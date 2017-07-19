<?php
  session_start();
  include_once("navbar.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <title>insert Title Form </title>
  <link rel="stylesheet" type="text/css" href="styles.css" media="all"/>
</head>

<body>

<style>
form, h1 {
  text-align:left;
  margin-left: 25px;
}
</style>

<div>

    <h1> Insertion DB </h1>

  <form name="insertTitle" action="insertTitle.php" method="post">
    <h2> Insertion artistes dans la table "artsites" </h2>
    <label for="nom">Nom d'Artiste</label><br/>
    <input type="text" name="nom_artiste" class = "champs3" size="80"/><br/>

    <input type="submit" value="inserer" class="insertbtn" name="insererArtiste" />


    <h2> Insertion titres dans la table "chansons" </h2>
    <label for="id_artiste">ID Artiste</label><br/>
    <input type="text" name="id_artiste" class = "champs3" size="80"/><br/><br/>

    <label for="titre">Titre</label><br/>
    <input type="text" name="titre" class = "champs3" size="80"/><br/><br/>

    <label for="artiste">Nom d'Artiste</label><br/>
    <input type="text" name="artiste" class = "champs3" size="80"/><br/><br/>

    <label for="titre">Lien</label><br/>
    <input type="text" name="lien" class = "champs3" size="80"/><br/>
    <input type="submit" value="inserer" class="insertbtn" name="insererTitle" />


    <h2> Insertion textes dans la table "paroles" </h2>

    <label for="titre">ID chanson</label><br/>
    <input type="text" name="id_titre" class = "champs3" size="80"/><br/><br/>

    <label for="nom">Nom d'Artiste</label><br/>
    <input type="text" name="nom_artiste" class = "champs3" size="80"/><br/><br/>

    <label for="texte">Paroles en français</label><br/>
    <input type="file" name="parolesFR" class="txtsendbtn" /><br/><br/>

    <label for="texte">Traduction en russe</label><br/>
    <input type="file" name="parolesRU" class="txtsendbtn"/><br/>

    <input type="submit" value="envoyer" class="insertbtn" name="insererParoles" />

   </form>
  </div>

<div id="footer">
  <br/>
  <br/>
</div>

</body>

</html>