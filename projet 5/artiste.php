<?php
  session_start();
?>

<!DOCTYPE html/>
<html>
<head>

  <meta charset="utf-8"/>
  <title> Acceuil projet </title>
  <link rel="stylesheet" type="text/css" href="styles.css" media="all"/>
  <script type="text/javascript" src="oXHR.js"></script>
  <script type="text/javascript">

  function request(oSelect) {
  var value = oSelect.options[oSelect.selectedIndex].value;
  var xhr   = getXMLHttpRequest();

  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
      readData(xhr.responseXML);
      document.getElementById("loader").style.display = "none";
    } else if (xhr.readyState < 4) {
      document.getElementById("loader").style.display = "inline";
    }
  };

  xhr.open("POST","titres.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("artiste=" + value);
  //print_r($_POST);
}

function readData(oData) {
  var nodes   = oData.getElementsByTagName("item");
  var oSelect = document.getElementById("titreSelect");
  var oOption, oInner;

  oSelect.innerHTML = "";
  for (var i=0, c=nodes.length; i<c; i++) {
    oOption = document.createElement("option");
    oInner  = document.createTextNode(nodes[i].getAttribute("titre"));
    oOption.value = nodes[i].getAttribute("id");

    oOption.appendChild(oInner);
    oSelect.appendChild(oOption);
  }
}


  </script>

</head>

<body>
  <?php
  include_once("navbar.php")
  ?>


  <h1> BIENVENUE </h1>

  <h2> APPRENEZ le français en chantant </h2>

<form action="lecture.php" name="submit" method="POST">
<div id="programBox">
  <p id="artistes">
  <select name="artiste" id="artisteSelect" onChange="request(this);">
    <option value="first"> Artiste </option>

    <?php
      $bdd = new PDO ('mysql:host=localhost; dbname=ProjetNFA021; charset=utf8', 'root', 'root');
      $query = $bdd->query('SELECT * FROM artistes ORDER BY artiste');
      while ($back = $query->fetch()) {
        echo "\t\t\t\t<option value=\"" . $back["artiste"] . "\">" . $back["artiste"] . "</option>\n";
      }
    ?>

  </select>
  <span id="loader" style="display: none;"><img src="images/loader.gif" alt="loading" /></span>
</p>


<p id="titres">
  <select name="titre" id="titreSelect">
    <option value="none"> Titre</option>
  </select>
</p>

  <input type="submit" name="valider" class="bouton" value="VALIDER"><br/>
</form>

<div id="accesSup">
<?php
if (isset($_SESSION['mail'])) {
  $admin = "asya@mail.com";
  if($_SESSION['mail'] == $admin) {

    echo '<a href="insertTitleForm.php">Ajouter des titres à la BDD</a>';

  }

}


?>

</div>


</body>
</html>