
<h1>Liste des points de collecte</h1>
<?php


//Ajoute un point de collecte
if(isset($_POST["ville"])){
    $tab=array();
    if(!($managerVille->existe($_POST["ville"]))){
      $managerVille->add($_POST["ville"]);
    }
    $ville=$managerVille->getVilNumByNom($_POST["ville"])->getVilNum();
    $tab["vil_num"]=$ville;
    $tab['point_lieu']=$_POST["adresse"];
    $pointdecollecte=new pointsdecollecte($tab);
    $managerPointsDeCollecte->add($pointdecollecte);
    header('Location: index.php?page=8');
    exit;
}

//Modifie un article

//Supprime un article
if(isset($_POST["supprimerPointDeCollecte"])){
    $managerPointsDeCollecte->deletePointDeCollecte($_POST["numPointDeCollecteASupprimer"]);
    header('Location: index.php?page=8');
    exit;
}

$villeTab = array();
$villeTab = $managerVille->getAllVille();
foreach($villeTab as $ville){
  echo "<h2>" . $ville->getVilNom() . "</h2>";
  $AllPoint = array();
  $AllPoint = $managerPointsDeCollecte->getPointByVille($ville->getVilNum());

  foreach($AllPoint as $point){
    if(isset($_POST["modifierPointDeCollecte"]) && $_POST["numPointDeCollecteAModifier"]==$point->getPointNum()){
        $_SESSION["numPointDeCollecteAModifier"]=$point->getPointNum();
        ?>
        <div id="ajouterArticle">
            <form method="POST" action="#">
                <label>Ville du point de collecte:</label>
                <input  type="text" name="VilleModifie" value="<?php echo $point->getPointVille(); ?>" required>
                <br>
                <label>Visibilité:</label>
                <input name="visibilitePointDeCollecteModifier" type="radio" value="0" <?php if($point->getPointVisibilite()==0){echo "cheched";}?>>non</input>
                <input name="visibilitePointDeCollecteModifier" type="radio" value="1"   <?php if($point->getPointVisibilite()==1){echo "cheched";}?>>oui</input>
                <textarea name="lieuModifie" rows="8" required><?php echo $point->getPointLieu(); ?></textarea>
                <br>

                <input class="bouton" type="submit" value="Modifier le point de collecte">
            </form>
        </div>
    <?php
    }else{
      echo "<p>" . $point->getPointLieu() ."</p>";

      if(isset($_SESSION["login"])){
          if(!isset($_POST["modifierPointDeCollecte"]) || (isset($_POST["modifierPointDeCollecte"]) && $_POST["numPointDeCollecteAModifier"]!=$point->getPointNum())){?>
              <div class="voletGestionPointdeCollecte">
                  <form class="supprimerPointDeCollecte" method="POST" action="#">
                      <input name="supprimerPointDeCollecte" type="submit" value="X">
                      <input name="numPointDeCollecteASupprimer" type="hidden" value="<?php echo $point->getPointNum(); ?>">
                  </form>
                  <form class="modifierPointDeCollecte" method="POST" action="#">
                      <input name="modifierPointDeCollecte" type="submit" value="M">
                      <input name="numPointDeCollecteAModifier" type="hidden" value="<?php echo $point->getPointNum() ;?>">
                  </form>
              </div>
          <?php
          }
          if(isset($_POST["modifierPointDeCollecte"])){
              $tab=array();
              $tab['point_num']=$_SESSION["numPointDeCollecteAModifier"];
              $tab["vil_num"]=$_POST["VilleModifie"];
              $tab["point_visibilite"]=$_POST["visibilitePointDeCollecteModifier"];
              $tab["point_lieu"]=$_POST["lieuModifie"];
              $pointdecollecte=new pointsdecollecte($tab);

              $managerPointsDeCollecte->modifierPointDeCollecte($pointdecollecte);
              header('Location: index.php?page=8');
              exit;
          }

        }
      }
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
