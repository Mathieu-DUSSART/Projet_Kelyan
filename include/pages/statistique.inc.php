<h1>Statistique</h1>
<?php
$tabPoint = $managerPointsDeCollecte->getAllPoint();
foreach ($tabPoint as $point) {
  echo "<h2>" . $managerVille->getVilNomByNum($point->getPointVille())->getVilNom() . " : " . $point->getPointLieu() . " : </h2>";
  $tabStatistique=$managerStatistique->getStatistiqueByPoint($point->getPointNum());
  foreach ($tabStatistique as $stat) {
    echo "<p>" . $stat->getStatistique() . "</p>";
  }
}
 ?>
