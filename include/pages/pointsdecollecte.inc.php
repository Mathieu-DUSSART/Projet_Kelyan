
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
    $pointdecollecte=new PointsDeCollecte($tab);
    $managerPointsDeCollecte->add($pointdecollecte);
    header('Location: index.php?page=8');
    exit;
}

//Modifie un point de collecte
if(isset($_POST["VilleModifie"])){
    $villePoint=$managerPointsDeCollecte->getVilleParPointNum($_SESSION["numPointDeCollecteAModifier"])->getPointVille();
    $tab=array();
    $tab['point_num']=$_SESSION["numPointDeCollecteAModifier"];
    if(!($managerVille->existe($_POST["VilleModifie"]))){
      $managerVille->add($_POST["VilleModifie"]);
    }

    $tab["vil_num"]=$managerVille->getVilNumByNom($_POST["VilleModifie"])->getVilNum();
    $tab["point_visibilite"]=$_POST["visibilitePointDeCollecteModifier"];
    $tab["point_lieu"]=$_POST["lieuModifie"];
    $pointdecollecte=new PointsDeCollecte($tab);

    $managerPointsDeCollecte->modifierPointDeCollecte($pointdecollecte);

    $nbLieuVille=$managerPointsDeCollecte->getNbLieuParVille($villePoint);

    if($nbLieuVille==0){
      $managerVille->delete($villePoint);
    }


    header('Location: index.php?page=8');
    exit;
}
//Supprime un point de collecte
if(isset($_POST["supprimerPointDeCollecte"])){
    $villePoint=$managerPointsDeCollecte->getVilleParPointNum($_POST["numPointDeCollecteASupprimer"])->getPointVille();

    $managerPointsDeCollecte->deletePointDeCollecte($_POST["numPointDeCollecteASupprimer"]);

    $nbLieuVille=$managerPointsDeCollecte->getNbLieuParVille($villePoint);

    if($nbLieuVille==0){
      $managerVille->delete($villePoint);
    }


    header('Location: index.php?page=8');
    exit;
}


$villeTab = array();
$villeTab = $managerVille->getAllVille();?>

<div id="divChoixVillePoint">
    <form action="#" method="POST">
        <label>Ville : </label>
        <select name="selectVillePoint">
            <?php
            foreach($villeTab as $ville){
              if ($ville->getVilNum()==$_POST["selectVillePoint"]){

                  echo "<option value=\"" . $ville->getVilNum() . "\" selected=\"selected\" >" . $ville->getVilNom() . "</option>";
              }else{
                echo "<option value=\"" . $ville->getVilNum() . "\">" . $ville->getVilNom() . "</option>";
            }
          }?>
        </select>
        <input type="submit" value="Valider">
    </form>
</div>
<br>

<?php
if(isset($_POST["selectVillePoint"])){
    $AllPoint = array();
    $AllPoint = $managerPointsDeCollecte->getPointByVille($_POST["selectVillePoint"]);
    if(empty($AllPoint)){
    echo "<p class=\"lieuxPoint\">Aucun point de collecte dans cette ville</p>";
    }
    foreach($AllPoint as $point){

            echo "<p class=\"lieuxPoint\"> - " . $point->getPointLieu() ."</p>";

        if(isset($_SESSION["login"])){
            if(!isset($_POST["modifierPointDeCollecte"]) || (isset($_POST["modifierPointDeCollecte"]) && $_POST["numPointDeCollecteAModifier"]!=$point->getPointNum())){?>
                <div class="voletGestionPointdeCollecte">
                  <label > t mort</label>
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
        }
    }
}


if(isset($_SESSION["login"])){?>
    <div id="formulaireAjoutArticle">
        <form method="POST" action="#">
            <label>Ville:</label>
            <input  type="text" name="ville" placeholder="Ville du point de collecte ..." required>
            <br>
            <label>lieu:</label>
            <textarea name="adresse" placeholder="lieu ..." rows="2" required></textarea>
            <br>
            <input class="bouton" type="submit" value="Ajouter le point de collecte">
        </form>
    </div>
<?php
}

if(isset($_POST["numPointDeCollecteAModifier"]) ){
    $point=$managerPointsDeCollecte->getPointByNum($_POST["numPointDeCollecteAModifier"]);
    ?>
    <div id="ajouterArticle">
        <form method="POST" action="#">
            <label>Ville du point de collecte:</label>
            <input  type="text" name="VilleModifie" value="<?php echo $managerVille->getVilNomByNum($point->getPointVille())->getVilNom(); ?>" required>
            <br>
            <label>Visibilité:</label>
            <input name="visibilitePointDeCollecteModifier" type="radio" value="0" <?php if($point->getPointVisibilite()==0){echo "checked";}?>>non</input>
            <input name="visibilitePointDeCollecteModifier" type="radio" value="1"  <?php if($point->getPointVisibilite()==1){echo "checked";}?>>oui</input>
            <textarea name="lieuModifie" rows="8" required><?php echo $point->getPointLieu(); ?></textarea>
            <br>
            <input class="bouton" type="submit" value="Modifier le point de collecte">
        </form>
    </div>
<?php
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
