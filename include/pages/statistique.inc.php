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
    echo "<p> statistique de " . $stat->getStatistique() . "</p>";
  }
}

if(isset($_SESSION["login"]) ){?>
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
if(isset($_SESSION["login"]) && isset($_POST["selectPoint"]) && empty($_POST["modifPoint"]) ){

  $tab=array();
  $tab["statistique"]=$_POST["valeurStatistique"];
  $tab["point_num"]=$_POST["selectPoint"];
  $tab["statistique_date"]=date_create($_POST["date"]);
  $statistique = new Statistique($tab);
  $managerStatistique->add($statistique);
}

if(isset($_SESSION["login"]) && isset($_POST["selectPoint"]) && isset($_POST["modifPoint"])){






}
 ?>
