<h1>Liste des points de collecte</h1>
<?php
$villeTab = array();
$villeTab = $managerVille->getAllVille();
foreach($villeTab as $ville){
  echo "<h2>" . $ville->getVilNom() . "</h2>";
  $AllPoint = array();
  $AllPoint = $managerPointsDeCollecte->getPointByVille($ville->getVilNom());
  foreach($AllPoint as $point){
      echo "<p>" . $point->getPointLieu() ."</p>";
  }
}
//(1) On inclut la classe de Google Maps pour générer ensuite la carte.
require('classes/GoogleMapAPI.class.php');

//(2) On crée une nouvelle carte; Ici, notre carte sera $map.
$map = new GoogleMapAPI('map');

//(3) On ajoute la clef de Google Maps.
$map->setAPIKey('AIzaSyB_rX6lPiKr6Hn7Rrppwro1H02D3WAN82Y');

//(4) On ajoute les caractéristiques que l'on désire à notre carte.
$map->setWidth("800px");
$map->setHeight("500px");
$map->setCenterCoords ('2', '48');
$map->setZoomLevel (5);

//(5) On applique la base XHTML avec les fonctions à appliquer ainsi que le onload du body.


$map->printMap();
?>
