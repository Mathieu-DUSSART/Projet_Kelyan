<h1>Statistique</h1>
<?php
$tabPoint = $managerPointsDeCollecte->getAllPoint();
foreach ($tabPoint as $point) {
  $num = $point->getPointVille();
  $ville=$managerVille->getVilNomByNum($num);
  echo "<h2>" . $ville->getVilNom() . " : " . $point->getPointLieu() . " : </h2>";
  $tabStatistique=$managerStatistique->getStatistiqueByPoint($point->getPointNum());
  foreach ($tabStatistique as $stat) {
    echo "<p>" . $stat->getStatistique() . "</p>";
  }
}
 ?>
