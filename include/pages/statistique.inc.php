<h1>Statistique</h1>
<?php
//Listage des statistique par Point de Collecte
$tabVille = $managerVille->getAllVille();


$villeTab = array();
$villeTab = $managerVille->getAllVille();?>
<div id="divChoixVillePoint">
<form action="#" method="POST">
    <label>Ville : </label>
    <select name="selectVillePoint">
        <?php
        foreach($villeTab as $ville){
            echo "<option value=\"" . $ville->getVilNum() . "\">" . $ville->getVilNom() . "</option>";
        }?>
    </select>
    <input type="submit" value="Valider">
</form>
</div>

<?php
if(isset($_POST["selectVillePoint"])){
    $AllPoint = array();
    $AllPoint = $managerPointsDeCollecte->getPointByVille($_POST["selectVillePoint"]);
    foreach ($AllPoint as $point) {
        echo "<dd> <h3>". $point->getPointLieu() . " : </h2>";
        $tabStatistique=$managerStatistique->getStatistiqueByPoint($point->getPointNum());
        foreach ($tabStatistique as $stat) {
          echo "<dd> <p> statistique du ".$stat->getDate()." nombre de bouchons récoltés : " . $stat->getStatistique() . "</p>";
          ?>
          <form class="supprimer" method="POST" action="#">
              <input class="boutonSuppr" name="supprimerStatistique" type="submit" value="X">
              <input class="num" name="numStatSupprimer" type="hidden" value="<?php echo $stat->getNum();?>">
            </form>
            <form class="modifierPointDeCollecte" method="POST" action="#">
              <input name="modifierPointDeCollecte" type="submit" value="M">
              <input class="numModif" name="numStatModifier" type="hidden" value="<?php echo $stat->getNum();?>">
              <input name="numPointDeCollecteAModifier" type="hidden" value="<?php echo $stat->getPoint();?>">
            </form>
            <?php
        }
    }
}

if(isset($_SESSION["login"]) && empty($_POST["numStatModifier"]) ){

  if(empty($_POST['selectVilleAjout'])){

  ?>
  <div id="ajouterStatistique">
  <form method="POST" action="#">

    <label>Ville : <label>
    <select id="selectVilleAjout" name="selectVilleAjout"><?php
        foreach ($tabVille as $ville) {

          echo "<option name=\"numVilleAjouter\" value=\"" . $ville->getVilNum() ."\">" .  $ville->getVilNom() . "</option>";
        }

          ?>  <input name="validerStatistique" type="submit" value="valider">
        </select>
    </form><?php
  }
    if(isset($_POST['selectVilleAjout'])){

        $tabPointAjout=$managerPointsDeCollecte->getPointByVille($_POST['selectVilleAjout']);
        $_SESSION['numVilleAjouter']=$_POST['selectVilleAjout'];
        ?>
          <div id="ajouterStatistique">
            <form method="POST" action="#">
          <label>Point de collecte : <label>
          <select id="selectPoint" name="selectPoint">
          <?php
          foreach ($tabPointAjout as $point) {

            echo "<option value=\"" . $point->getPointNum() ."\"> " . $point->getPointLieu() . "</option>";
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
}
if(isset($_SESSION["login"]) && isset($_POST["selectPoint"]) && empty($_POST["numStatSupprimer"]) && empty($_POST["numStatModifier"]) ){

  $tab=array();
  $tab["statistique"]=$_POST["valeurStatistique"];
  $tab["point_num"]=$_POST["selectPoint"];
  $date= getEnglishDate($_POST["date"]);
  $tab["statistique_date"]=$date;
  $statistique = new Statistique($tab);
  $managerStatistique->add($statistique);
}

if(isset($_SESSION["login"]) && empty($_POST["selectPoint"]) && isset($_POST["numStatSupprimer"]) && empty($_POST["numStatModifier"])){
  $managerStatistique->deleteStatistique($_POST["numStatSupprimer"]);


}

if(isset($_SESSION["login"]) && empty($_POST["selectPoint"]) && empty($_POST["numStatSupprimer"]) && isset($_POST["numStatModifier"])){

  $vilNum=$managerPointsDeCollecte->getVilleParPointNum($_POST["numPointDeCollecteAModifier"]);
  $statModifer=$managerStatistique->getStatistiqueByNum($_POST["numStatModifier"]);
  $tabPoint = $managerPointsDeCollecte->getPointByVille($vilNum->getPointVille());
?>
  <div id="ajouterStatistique">
  <form class="modifier" method="POST" action="#">
    <label>Point de collecte : <label>
      <select id="selectPointCollecte" name="selectPointModif">
        <?php
          foreach ($tabPoint as $point) {
            $num = $point->getPointVille();
            $ville=$managerVille->getVilNomByNum($num); ?>
            <option value= <?php echo "\"". $point->getPointVille() ."\"" ;if($vilNum==$point->getPointVille()){ echo "selected=\"selected\"";  } echo ">"; echo   $ville->getVilNom() . " : " . $point->getPointLieu() ;?></option>
        <?php  }  ?>
      </select>

      <label>Statistique :</label>
      <input type="number" name="valeurStatistiqueModif"  value ="<?php echo $statModifer->getStatistique() ; ?>">
      <input type="hidden" name="numStatistiqueModif"  value ="<?php echo $_POST["numStatModifier"] ; ?>">

      <label>Date : </label>
      <input type="text" class="datepicker" name="dateModif" value ="<?php echo $statModifer->getDate() ;?>">
      <input class="boutonModifier" type="button" name="validerStatistique" value="valider">
  </form>
  </div>

<?php
}

if(isset($_SESSION["login"]) && isset($_POST["selectPointModif"]) && empty($_POST["numStatSupprimer"]) && isset($_POST["dateModif"])){
  echo "stat_num";
  echo $_POST["numStatistiqueModif"];
  $managerStatistique->modifierStatistique($_POST["valeurStatistiqueModif"],$_POST["selectPointModif"],$_POST["dateModif"],$_POST["numStatistiqueModif"]);


}
 ?>
