<h1>Liste des points de collecte</h1>
<?php
$villeTab = array();
$villeTab = $managerVille->getAllVille();
foreach($villeTab as $ville){
  echo "<h2>" . $ville->getVilNom() . "</h2>";
  $AllPoint = array();
  $AllPoint = $managerPointsDeCollecte->getPointByVille($ville->getVilNum());
  foreach($AllPoint as $point){
      echo "<p>" . $point->getPointLieu() ."</p>";
  }
}
//Ajoute un point de collecte
if(isset($_POST["ville"])){
    $tab=array();
    echo "0";
    print_r($_POST["ville"]);
    if(!($managerVille->existe($_POST["ville"]))){
      echo"0.5";
      $managerVille->add($_POST["ville"]);
    }

    $ville=$managerVille->getVilNumByNom($_POST["ville"])->getVilNum();
    echo "1";
    print_r($ville);
    echo "2";
    $tab["vil_num"]=$ville;
    $tab['point_lieu']=$_POST["adresse"];
    $pointdecollecte=new pointsdecollecte($tab);
    $managerPointsDeCollecte->add($pointdecollecte);
    header('Location: index.php?page=8');
    exit;
}

//Modifie un article
if(isset($_POST["titreModifie"])){
    $tab=array();
    $tab["art_num"]=$_SESSION["numArticleAModifier"];
    $tab["art_titre"]=$_POST["titreModifie"];
    $tab["art_texte"]=$_POST["texteModifie"];
    $article=new Article($tab);
    $managerArticle->modifierArticle($article);
    header('Location: index.php?page=8');
    exit;
}

//Supprime un article

if(isset($_SESSION["login"])){?>
  <h2> Ajouter un point de collecte </h2>
    <div id="ajouterPointDeCollecte">
        <form method="POST" action="#">
            <label>Ville du point de Collecte :</label>
            <input  type="text" name="ville" placeholder="Ville ..." required>
            <br>
            <label>Adresse du point de Collecte:</label>
            <input  type="text" name="adresse" placeholder="Adresse ..." required>
            <br>
            <input class="bouton" type="submit" value="Ajouter point de collecte">
        </form>
    </div>
<?php
}?>

<?php
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
