<!DOCTYPE html>
<html>
<head>
  <style type="text/css">

    ul.topnav {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #464948;
}

ul.topnav li {float: right;}

ul.topnav li a  {
    display: inline-block;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    transition: 0.3s;
    font-size: 17px;
}

#utilisateur {
  text-align: left;
    color: #f2f2f2;
    padding: 14px 16px;
    text-decoration: none;
    transition: 0.3s;
    font-size: 17px;
}

ul.topnav li a:hover {background-color: #555;}

ul.topnav li.icon {display: none;}

@media screen and (max-width:680px) {
  ul.topnav li:not(:first-child) {display: none;}
  ul.topnav li.icon {
    float: right;
    display: inline-block;
  }
}

@media screen and (max-width:680px) {
  ul.topnav.responsive {position: relative;}
  ul.topnav.responsive li.icon {
    position: absolute;
    right: 0;
    top: 0;
  }
  ul.topnav.responsive li {
    float: none;
    display: inline;
  }
  ul.topnav.responsive li a {
    display: block;
    text-align: left;
  }
}

</style>
</head>

<body>

  <?php
    include_once("connexion.php");
    include_once("creationCompte.php");
  ?>

<nav class="navbar">
  <ul class="topnav" id="myTopnav">
    <li id="1"><a href="artiste.php">Home</a></li>


  <?php

  if (!isset($_SESSION['prenom'])) {
    echo '<li id="2"><a href="#overlay3">Créer un compte</a></li>';
    echo '<li id="3"><a href="#overlay2">Se connecter</a></li>';
  }

  if (isset($_SESSION['prenom'])) {
    echo '<li id="4"><a href="deconnexion.php">Se deconnecter</a></li>';
  }

  ?>

    <li class="icon">
      <a href="javascript:void(0);" onclick="myFunction()">&#9776;</a>
    </li>

    <div id="utilisateur">
      <?php
        if (isset($_SESSION['prenom'])) {
          $str = strtoupper($_SESSION['prenom']);
          echo "Bonjour ".$str;
        }
      ?>
    </div>
  </ul>


</nav>
</body>
</html>