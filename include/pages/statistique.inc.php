<h1>Statistique</h1>
<?php
//Listage des statistique par Point de Collecte
$tabPoint = $managerPointsDeCollecte->getAllPoint();
foreach ($tabPoint as $point) {
  $num = $point->getPointVille();
  $ville=$managerVille->getVilNomByNum($num);
  echo "<h2>" . $ville->getVilNom() . " : " . $point->getPointLieu() . " : </h2>";
  $tabStatistique=$managerStatistique->getStatistiqueByPoint($point->getPointNum());
  foreach ($tabStatistique as $stat) {
    echo "<p> statistique du ".$stat->getDate()." nombre de bouchons récoltés : " . $stat->getStatistique() . "</p>";
    ?>
    <form class="supprimerStatistique" method="POST" action="#">
        <input name="supprimerStatistique" type="submit" value="X">
        <input name="numPointDeCollecteASupprimer" type="hidden" value="<?php echo $stat->getPoint();?>">
        <input name="dateStatASupprimer" type="hidden" value="<?php echo $stat->getDate(); ?>">
        <input name="statSupprimer" type="hidden" value="<?php echo $stat->getStatistique(); ?>">
    </form>
    <form class="modifierPointDeCollecte" method="POST" action="#">
        <input name="modifierPointDeCollecte" type="submit" value="M">
        <input name="numPointDeCollecteAModifier" type="hidden" value="<?php echo $stat->getPoint();?>">
        <input name="dateStatAModifier" type="hidden" value="<?php echo $stat->getDate(); ?>">
        <input name="statModifier" type="hidden" value="<?php echo $stat->getStatistique(); ?>">

    </form>
    <?php
  }
}

if(isset($_SESSION["login"]) && empty($_POST["numPointDeCollecteAModifier"]) ){?>
  <div id="ajouterStatistique">
  <form method="POST" action="#">
    <label>Point de collecte : <label>
      <select id="selectPointCollecte" name="selectPoint">
        <?php
          foreach ($tabPoint as $point) {
            $num = $point->getPointVille();
            $ville=$managerVille->getVilNomByNum($num);
            echo "<option value=\"" . $point->getPointVille() ."\">" .  $ville->getVilNom() . " : " . $point->getPointLieu() . "</option>";
          }
        ?>
      </select>
      <label>Statistique :</label>
      <input name="valeurStatistique"type="number" required>

      <label>Date : </label>
      <input type="text" class="datepicker" name="date" required>
      <input name="validerStatistique" type="submit" value="valider">
  </form>
  </div>
<?php
}
if(isset($_SESSION["login"]) && isset($_POST["selectPoint"]) && empty($_POST["numPointDeCollecteASupprimer"]) && empty($_POST["numPointDeCollecteAModifier"]) ){

  $tab=array();
  $tab["statistique"]=$_POST["valeurStatistique"];
  $tab["point_num"]=$_POST["selectPoint"];
  $date= getEnglishDate($_POST["date"]);
  $tab["statistique_date"]=$date;
  $statistique = new Statistique($tab);
  $managerStatistique->add($statistique);
}

if(isset($_SESSION["login"]) && empty($_POST["selectPoint"]) && isset($_POST["numPointDeCollecteASupprimer"]) && empty($_POST["numPointDeCollecteAModifier"])){

  $tabSuppr=array();
  $tabSuppr["statistique"]=$_POST["statSupprimer"];
  $tabSuppr["point_num"]=$_POST["numPointDeCollecteASupprimer"];
  $tabSuppr["statistique_date"]=$_POST["dateStatASupprimer"];
  $statistiqueSuppr = new Statistique($tabSuppr);
  $managerStatistique->deleteStatistique($statistiqueSuppr);


}

if(isset($_SESSION["login"]) && empty($_POST["selectPoint"]) && empty($_POST["numPointDeCollecteASupprimer"]) && isset($_POST["numPointDeCollecteAModifier"])){

  $vilNum=$managerPointsDeCollecte->getVilleParPointNum($_POST["numPointDeCollecteAModifier"]);
?>
  <div id="ajouterStatistique">
  <form method="POST" action="#">
    <label>Point de collecte : <label>
      <select id="selectPointCollecte" name="selectPoint">
        <?php
          foreach ($tabPoint as $point) {
            $num = $point->getPointVille();
            $ville=$managerVille->getVilNomByNum($num); ?>
            <option value= <?php echo "\"". $point->getPointVille() ."\"" ;if($vilNum==$point->getPointVille()){ echo "selected=\"selected\"";  } echo ">"; echo   $ville->getVilNom() . " : " . $point->getPointLieu() ;?></option>
        <?php  }  ?>
      </select>

      <label>Statistique :</label>
       <?php echo $_POST["statModifier"]; ?>
      <input type="number" name="valeurStatistique"  value ="<?php echo $_POST["statModifier"] ; ?>">

      <label>Date : </label>
      <input type="text" class="datepicker" name="date" value ="<?php echo $_POST["dateStatAModifier"] ;?>">
      <input name="validerStatistique" type="submit" value="valider">
  </form>
  </div>

<?php

  /*$tabSuppr=array();
  $tabSuppr["statistique"]=$_POST["statModifier"];
  $tabSuppr["point_num"]=$_POST["numPointDeCollecteAModifier"];
  $tabSuppr["statistique_date"]=$_POST["dateStatAModifier"];
  $statistiqueSuppr = new Statistique($tabSuppr);
  $managerStatistique->deleteStatistique($statistiqueSuppr);*/


}
 ?>
