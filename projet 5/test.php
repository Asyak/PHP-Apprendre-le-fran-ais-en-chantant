<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <title>Test de connaissances</title>
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
$tit = $_SESSION['titre'];
$request=$bdd->prepare('SELECT * FROM chansons WHERE id = ?');
$request->execute(array($tit));
while ($dons = $request->fetch())
{
  echo "<h2>".$dons['titre']." - ".$dons['artiste']."</h2><br/><br/>";
}
$request->closeCursor();



// ------ FUNCTIONS ------

function choix_mot_ru_au_hasard_BD() {
  $bdd = new PDO ('mysql:host=localhost; dbname=ProjetNFA021; charset=utf8', 'root', 'root');
  $requette=$bdd->query('SELECT * FROM vocabulaire');
  $nbL=0;
  while ($nbLignes = $requette->fetch()) {
    $nbL++;
  }
  $requette->closeCursor();

  // selectionne d'un id_mot français au hasard
  $rand_check = random_int(1, $nbL);

  $rep=$bdd->prepare('SELECT * FROM vocabulaire WHERE id_mot = ?');
  $rep->execute(array($rand_check));
  $don=$rep->fetch();
  return $don['traduction_ru'];
}

/*function verif_doublons($wrd, $doublons_tab) {
  if (!in_array($wrd, $doublons_tab)) {
    array_push($doublons_tab, "$wrd");
  }
  return $doublons_tab;
  print_r ($doublons_tab);
}*/


function choix_mot_fr_dans_fichier($fil) {
  $fich_lign =file($fil);
  $j = count($fich_lign);
  $lign= $fich_lign[random_int(0,$j-1)];

  $mooots=explode(" ", rtrim($lign));
  $m=count($mooots);
  $mooot=$mooots[random_int(0,$m-1)];

  while ($mooots == "") {
    $mooot = choix_mot_dans_fichier($fil);
  }

  return $mooot;
}

function recherche_mot_fr_dans_BD($word_to_verify) {
  $bdd = new PDO ('mysql:host=localhost; dbname=ProjetNFA021; charset=utf8', 'root', 'root');
  $recherche=$bdd->prepare('SELECT mot_fr, traduction_ru FROM vocabulaire WHERE mot_fr = ?');
  $recherche->execute(array($word_to_verify));
  $rech=$recherche->fetch();
  if ($rech != false){
    return true;
  } else {
    return false;
  }
  $recherche->closeCursor();
}

function recherche_traduction_ru($var) {
  $bdd = new PDO ('mysql:host=localhost; dbname=ProjetNFA021; charset=utf8', 'root', 'root');
  $recherch=$bdd->prepare('SELECT * FROM vocabulaire WHERE mot_fr = ?');
  $recherch->execute(array($var));
  $rech=$recherch->fetch();
  return $rech['traduction_ru'];

}

// -------- FUNCTIONS ---------

// recherche lien du titre et preparation lecture du fichier
$req=$bdd->prepare('SELECT * FROM paroles WHERE id_chanson = ?');
$req->execute(array($tit));
while ($donnees = $req->fetch())
{
  $text=$donnees['txt_francais'];
}

$file= "textes/fr/".$text;
$text=fopen($file, "r");


// lecture aleatoire d'une ligne de fichier
$fichier_ligne = file($file);
$i = count($fichier_ligne);
$id = random_int(1,$i-1);
$ligne = $fichier_ligne[$id];

// premier check
$wrd_fr= choix_mot_fr_dans_fichier($file);
$wrd_fr= strtolower($wrd_fr);
$wrd_fr_verified = recherche_mot_fr_dans_BD($wrd_fr);

while (!$wrd_fr_verified) {
  $wrd_fr= choix_mot_fr_dans_fichier($file);
  $wrd_fr= strtolower($wrd_fr);
  $wrd_fr_verified = recherche_mot_fr_dans_BD($wrd_fr);
  if ($wrd_fr_verified == true) {
    $wrd_fr = $wrd_fr;
  }
}


  $wrd_ru = recherche_traduction_ru($wrd_fr);

  $mot1 = $wrd_ru; // - c'est la reponse correct
  //valeur au hazar des 3 checks
  $mot2 = choix_mot_ru_au_hasard_BD();
  $mot3 = choix_mot_ru_au_hasard_BD();
  $mot4 = choix_mot_ru_au_hasard_BD();

  $check_tab = array($mot1, $mot2, $mot3, $mot4);
  shuffle($check_tab);


?>

  <label for="test"><?php echo $wrd_fr;?> --> <br/></label>
  <input type="checkbox" name="chk[]" id="check0" value=<?php echo $check_tab[0]; ?> onclick="reponseAlert0()"/><?php echo $check_tab[0]; ?>
  <input type="checkbox" name="chk[]" id="check1" value=<?php echo $check_tab[1]; ?> onclick="reponseAlert1()"/><?php echo $check_tab[1]; ?>
  <input type="checkbox" name="chk[]" id="check2" value=<?php echo $check_tab[2]; ?> onclick="reponseAlert2()"/><?php echo $check_tab[2]; ?>
  <input type="checkbox" name="chk[]" id="check3" value=<?php echo $check_tab[3]; ?> onclick="reponseAlert3()"/><?php echo $check_tab[3]; ?>

  <?php

  echo "<br/><br/><br/>";


  // deuxième check
$wrd_fr2= choix_mot_fr_dans_fichier($file);
$wrd_fr2= strtolower($wrd_fr2);
$wrd_fr2_verified = recherche_mot_fr_dans_BD($wrd_fr2);

while (!$wrd_fr2_verified) {
  $wrd_fr2= choix_mot_fr_dans_fichier($file);
  $wrd_fr2= strtolower($wrd_fr2);
  $wrd_fr2_verified = recherche_mot_fr_dans_BD($wrd_fr2);
  if ($wrd_fr2_verified == true) {
    $wrd_fr2 = $wrd_fr2;
  }
}


  $wrd_ru2 = recherche_traduction_ru($wrd_fr2);

  $mot1 = $wrd_ru2; // - c'est la reponse correct
  //valeur au hazar des 3 checks
  $mot2 = choix_mot_ru_au_hasard_BD();
  $mot3 = choix_mot_ru_au_hasard_BD();
  $mot4 = choix_mot_ru_au_hasard_BD();

  $check_tab = array($mot1, $mot2, $mot3, $mot4);
  shuffle($check_tab);

  ?>

  <label for="test"><?php echo $wrd_fr2;?> --> <br/></label>
  <input type="checkbox" name="chk2[]" id="check4" value=<?php echo $check_tab[0]; ?> onclick="reponseAlert4()"/><?php echo $check_tab[0]; ?>
  <input type="checkbox" name="chk2[]" id="check5" value=<?php echo $check_tab[1]; ?> onclick="reponseAlert5()"/><?php echo $check_tab[1]; ?>
  <input type="checkbox" name="chk2[]" id="check6" value=<?php echo $check_tab[2]; ?> onclick="reponseAlert6()"/><?php echo $check_tab[2]; ?>
  <input type="checkbox" name="chk2[]" id="check7" value=<?php echo $check_tab[3]; ?> onclick="reponseAlert7()"/><?php echo $check_tab[3]; ?>


<?php
echo "<br/><br/><br/>";

// troisième check
$wrd_fr3= choix_mot_fr_dans_fichier($file);
$wrd_fr3= strtolower($wrd_fr3);
$wrd_fr3_verified = recherche_mot_fr_dans_BD($wrd_fr3);

while (!$wrd_fr3_verified) {
  $wrd_fr3= choix_mot_fr_dans_fichier($file);
  $wrd_fr3= strtolower($wrd_fr3);
  $wrd_fr3_verified = recherche_mot_fr_dans_BD($wrd_fr3);
  if ($wrd_fr3_verified == true) {
    $wrd_fr3 = $wrd_fr3;
  }
}


  $wrd_ru3 = recherche_traduction_ru($wrd_fr3);

  $mot1 = $wrd_ru3; // - c'est la reponse correct
  //valeur au hazar des 3 checks
  $mot2 = choix_mot_ru_au_hasard_BD();
  $mot3 = choix_mot_ru_au_hasard_BD();
  $mot4 = choix_mot_ru_au_hasard_BD();

  $check_tab = array($mot1, $mot2, $mot3, $mot4);
  shuffle($check_tab);

?>

  <label for="test"><?php echo $wrd_fr3;?> --> <br/></label>
  <input type="checkbox" name="chk3[]" id="check8" value=<?php echo $check_tab[0]; ?> onclick="reponseAlert8()"/><?php echo $check_tab[0]; ?>
  <input type="checkbox" name="chk3[]" id="check9" value=<?php echo $check_tab[1]; ?> onclick="reponseAlert9()"/><?php echo $check_tab[1]; ?>
  <input type="checkbox" name="chk3[]" id="check10" value=<?php echo $check_tab[2]; ?> onclick="reponseAlert10()"/><?php echo $check_tab[2]; ?>
  <input type="checkbox" name="chk3[]" id="check11" value=<?php echo $check_tab[3]; ?> onclick="reponseAlert11()"/><?php echo $check_tab[3]; ?>


<?php
echo "<br/><br/><br/>";

// quatrième check
$wrd_fr4= choix_mot_fr_dans_fichier($file);
$wrd_fr4= strtolower($wrd_fr4);
$wrd_fr4_verified = recherche_mot_fr_dans_BD($wrd_fr4);

while (!$wrd_fr4_verified) {
  $wrd_fr4= choix_mot_fr_dans_fichier($file);
  $wrd_fr4= strtolower($wrd_fr4);
  $wrd_fr4_verified = recherche_mot_fr_dans_BD($wrd_fr4);
  if ($wrd_fr4_verified == true) {
    $wrd_fr4 = $wrd_fr4;
  }
}


  $wrd_ru4 = recherche_traduction_ru($wrd_fr4);

  $mot1 = $wrd_ru4; // - c'est la reponse correct
  //valeur au hazar des 3 checks
  $mot2 = choix_mot_ru_au_hasard_BD();
  $mot3 = choix_mot_ru_au_hasard_BD();
  $mot4 = choix_mot_ru_au_hasard_BD();

  $check_tab = array($mot1, $mot2, $mot3, $mot4);
  shuffle($check_tab);

?>

  <label for="test"><?php echo $wrd_fr4;?> --> <br/></label>
  <input type="checkbox" name="chk4[]" id="check12" value=<?php echo $check_tab[0]; ?> onclick="reponseAlert12()"/><?php echo $check_tab[0]; ?>
  <input type="checkbox" name="chk4[]" id="check13" value=<?php echo $check_tab[1]; ?> onclick="reponseAlert13()"/><?php echo $check_tab[1]; ?>
  <input type="checkbox" name="chk4[]" id="check14" value=<?php echo $check_tab[2]; ?> onclick="reponseAlert14()"/><?php echo $check_tab[2]; ?>
  <input type="checkbox" name="chk4[]" id="check15" value=<?php echo $check_tab[3]; ?> onclick="reponseAlert15()"/><?php echo $check_tab[3]; ?>


<script type="text/javascript">

// premier check
function reponseAlert0() {
  var elt_ok = '<?php echo $wrd_ru; ?>';
  var elt_to_compare = document.getElementById('check0').value;
  if (elt_ok == elt_to_compare) {
    alert ('BRAVOOOO!');
  } else {
    alert ('Mauvaise reponse!');
  }
}

function reponseAlert1() {
  var elt_ok = '<?php echo $wrd_ru; ?>';
  var elt_to_compare = document.getElementById('check1').value;
  if (elt_ok == elt_to_compare) {
    alert ('BRAVOOOO!');
  } else {
    alert ('Mauvaise reponse!');
  }
}

function reponseAlert2() {
  var elt_ok = '<?php echo $wrd_ru; ?>';
  var elt_to_compare = document.getElementById('check2').value;
  if (elt_ok == elt_to_compare) {
    alert ('BRAVOOOO!');
  } else {
    alert ('Mauvaise reponse!');
    var elt_red = elt_to_compare;
   // elt_red.style.color = "red";
  }
}

function reponseAlert3() {
  var elt_ok = '<?php echo $wrd_ru; ?>';
  var elt_to_compare = document.getElementById('check3').value;
  if (elt_ok == elt_to_compare) {
    alert ('BRAVOOOO!');
  } else {
    alert ('Mauvaise reponse!');
    var elt_red = elt_to_compare;
    // elt_red.style.color = "red";
  }
}

// deuxième check
function reponseAlert4() {
  var elt_ok = '<?php echo $wrd_ru2; ?>';
  var elt_to_compare = document.getElementById('check4').value;
  if (elt_ok == elt_to_compare) {
    alert ('BRAVOOOO!');
  } else {
    alert ('Mauvaise reponse!');
  }
}

function reponseAlert5() {
  var elt_ok = '<?php echo $wrd_ru2; ?>';
  var elt_to_compare = document.getElementById('check5').value;
  if (elt_ok == elt_to_compare) {
    alert ('BRAVOOOO!');
  } else {
    alert ('Mauvaise reponse!');
  }
}

function reponseAlert6() {
  var elt_ok = '<?php echo $wrd_ru2; ?>';
  var elt_to_compare = document.getElementById('check6').value;
  if (elt_ok == elt_to_compare) {
    alert ('BRAVOOOO!');
  } else {
    alert ('Mauvaise reponse!');
  }
}

function reponseAlert7() {
  var elt_ok = '<?php echo $wrd_ru2; ?>';
  var elt_to_compare = document.getElementById('check7').value;
  if (elt_ok == elt_to_compare) {
    alert ('BRAVOOOO!');
  } else {
    alert ('Mauvaise reponse!');
  }
}

// troisième check
function reponseAlert8() {
  var elt_ok = '<?php echo $wrd_ru3; ?>';
  var elt_to_compare = document.getElementById('check8').value;
  if (elt_ok == elt_to_compare) {
    alert ('BRAVOOOO!');
  } else {
    alert ('Mauvaise reponse!');
  }
}

function reponseAlert9() {
  var elt_ok = '<?php echo $wrd_ru3; ?>';
  var elt_to_compare = document.getElementById('check9').value;
  if (elt_ok == elt_to_compare) {
    alert ('BRAVOOOO!');
  } else {
    alert ('Mauvaise reponse!');
  }
}

function reponseAlert10() {
  var elt_ok = '<?php echo $wrd_ru3; ?>';
  var elt_to_compare = document.getElementById('check10').value;
  if (elt_ok == elt_to_compare) {
    alert ('BRAVOOOO!');
  } else {
    alert ('Mauvaise reponse!');
  }
}

function reponseAlert11() {
  var elt_ok = '<?php echo $wrd_ru3; ?>';
  var elt_to_compare = document.getElementById('check11').value;
  if (elt_ok == elt_to_compare) {
    alert ('BRAVOOOO!');
  } else {
    alert ('Mauvaise reponse!');
  }
}

// quatrième check
function reponseAlert12() {
  var elt_ok = '<?php echo $wrd_ru4; ?>';
  var elt_to_compare = document.getElementById('check12').value;
  if (elt_ok == elt_to_compare) {
    alert ('BRAVOOOO!');
  } else {
    alert ('Mauvaise reponse!');
  }
}

function reponseAlert13() {
  var elt_ok = '<?php echo $wrd_ru4; ?>';
  var elt_to_compare = document.getElementById('check13').value;
  if (elt_ok == elt_to_compare) {
    alert ('BRAVOOOO!');
  } else {
    alert ('Mauvaise reponse!');
  }
}

function reponseAlert14() {
  var elt_ok = '<?php echo $wrd_ru4; ?>';
  var elt_to_compare = document.getElementById('check14').value;
  if (elt_ok == elt_to_compare) {
    alert ('BRAVOOOO!');
  } else {
    alert ('Mauvaise reponse!');
  }
}

function reponseAlert15() {
  var elt_ok = '<?php echo $wrd_ru4; ?>';
  var elt_to_compare = document.getElementById('check14').value;
  if (elt_ok == elt_to_compare) {
    alert ('BRAVOOOO!');
  } else {
    alert ('Mauvaise reponse!');
  }
}

</script>


<?php

echo "<br/><br/><br/><br/>";

?>



<div id="result">

</div>

<input type="button" class="bouton" id="suivantTest" onclick='document.location.reload(false)' value="Suivant -->"/>



