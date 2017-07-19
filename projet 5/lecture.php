<?php
session_start();
$_SESSION['titre'] = $_POST['titre'];

include_once("navbar.php");

?>

<!DOCTYPE html/>
<head>
  <meta charset="utf-8"/>
  <title>Lecture</title>
    <script type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="styles.css" media="all"/>

</head>

<body>
<?php

if (isset($_POST['valider'])) {

  if (isset($_POST['artiste'])) { ?>

  <h2><?php echo "<br/>".$_POST['artiste']; ?></h2>

  <?php

    if (isset($_POST['titre']))
    {
    $bdd = new PDO ('mysql:host=localhost; dbname=ProjetNFA021; charset=utf8', 'root', 'root');
    $query = $bdd->prepare('SELECT * FROM chansons WHERE id=?');
    $query->execute(array($_POST["titre"]));

    while ($reponse = $query->fetch())
    { ?>

  <h2><?php echo $reponse['titre']."<br/>"; ?></h2>

 <iframe width="560" height="315" id="video" src="https://www.youtube.com/embed/<?php echo $reponse['lien'];?>"
 frameborder="0" allowfullscreen></iframe>

 <br/><br/>
<?php

    }
    $query->closeCursor();
   }
  }

} else {
  echo " Mais je ne vois que dal!";
}

?>

<?php
  $bdd = new PDO ('mysql:host=localhost; dbname=ProjetNFA021; charset=utf8', 'root', 'root');
  $demande = $bdd->prepare('SELECT * FROM paroles WHERE id_chanson=?');
  $demande->execute(array($_POST["titre"]));

  while ($rep = $demande->fetch()) {
?>

<button onclick="afficherFR()" id="afficherFR" class="onclk">Afficher paroles en Français</button>
<button onclick="afficherRU()" id="afficherRU" class="onclk">Afficher paroles en Russe</button>
<br/>

<div id="paroles">
</div>

<span id="loader" style="display: none;"><img src="images/loader.gif" alt="loading" /></span>

<script type="text/javascript">
document.getElementById('afficherFR').onclick = function() {
  var val = afficherFR.innerHTML;
  val = (val.trim) ? val.trim() : val.replace(/^\s+/,'');
  var aff = "Afficher paroles en Français";
  aff = (aff.trim) ? aff.trim() : aff.replace(/^\s+/,'');
  var masq = "Masquer paroles en Français";
  masq = (masq.trim) ? masq.trim() : masq.replace(/^\s+/,'');

if (val == aff) {
   var iframe = document.createElement('iframe');
   var pere = document.getElementById('paroles');
   iframe.src = 'textes/fr/<?php echo $rep['txt_francais'];?>';
   pere.appendChild(iframe);
   iframe.setAttribute("id", "iframeFR");
   iframe.style.width = "460";
   iframe.style.height = "315";

   afficherFR.innerHTML = "Masquer paroles en Français";
}
if (val == masq) {
  var element = document.getElementById("iframeFR");
  element.parentNode.removeChild(element);
  afficherFR.innerHTML = "Afficher paroles en Français";
}

};

</script>

<script type="text/javascript">
document.getElementById('afficherRU').onclick = function() {
  var val = afficherRU.innerHTML;
  val = (val.trim) ? val.trim() : val.replace(/^\s+/,'');
  var aff = "Afficher paroles en Russe";
  aff = (aff.trim) ? aff.trim() : aff.replace(/^\s+/,'');
  var masq = "Masquer paroles en Russe";
  masq = (masq.trim) ? masq.trim() : masq.replace(/^\s+/,'');

 if (val == aff) {
    var iframe = document.createElement('iframe');
    iframe.src = 'textes/ru/<?php echo $rep['txt_russe'];?>';
    var pere = document.getElementById('paroles');
    pere.appendChild(iframe);
    iframe.setAttribute("id", "iframeRU");
    iframe.style.width = "460";
    iframe.style.height = "315";

    afficherRU.innerHTML = "Masquer paroles en Russe";
  }

  if (val == masq) {
    var element = document.getElementById("iframeRU");
    element.parentNode.removeChild(element);
    afficherRU.innerHTML = "Afficher paroles en Russe";
  }

};
</script>


<br/>

<form method="POST" action="vocabulaire.php">
  <input type="submit" class="bouton" value="VOCABULAIRE"></input>
  <input type="hidden" class="bouton" name="titre" value="<?php echo $_POST['titre'];?>"></input>
</form>

<?php

}
$query->closeCursor();
?>

<div id="footer">
<br/>

</div>

</body>
</html>

