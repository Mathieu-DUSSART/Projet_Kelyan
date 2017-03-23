
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
if(isset($_POST["numPointDeCollecteASupprimer"])){
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
    echo "<table>";
    $i = 0;
    $ville=[];
    foreach($AllPoint as $point){
        echo "<tr>";
            echo "<td> <p class=\"lieuxPoint\"> - " . $point->getPointLieu() ."</p> </td>";

        if(isset($_SESSION["login"])){
            if(!isset($_POST["modifierPointDeCollecte"]) || (isset($_POST["modifierPointDeCollecte"]) && $_POST["numPointDeCollecteAModifier"]!=$point->getPointNum())){?>
                <div class="voletGestionPointdeCollecte">
                    <td>
                        <form class="modifierPointDeCollecte" method="POST" action="#">
                            <input name="modifierArticle" class="boutonModifier " type="submit" value="" >
                            <input name="numPointDeCollecteAModifier" type="hidden" value="<?php echo $point->getPointNum() ;?>">
                        </form>
                    </td>
                    <td>
                        <form class="supprimerPointDeCollecte supprimer" method="POST" action="#">
                            <input name="supprimerArticle" class="boutonSupprimer " type="button" value="">
                            <input class="num" name="numPointDeCollecteASupprimer" type="hidden" value="<?php echo $point->getPointNum(); ?>">
                        </form>
                    </td>
                </div>
                <?php
                $address = $point->getPointLieu()." ".$managerVille->getVilNomByNum($_POST["selectVillePoint"])->getVilNom();

                // On prépare l'URL du géocodeur
                $geocoder = "http://maps.googleapis.com/maps/api/geocode/xml?address=%s&sensor=false";

                // Pour cette exemple, je vais considérer que ma chaîne n'est pas
                // en UTF8, le géocoder ne fonctionnant qu'avec du texte en UTF8

                $url_address = utf8_encode($address);

                    // Penser a encoder votre adresse
                    $url_address = urlencode($url_address);

                    // On prépare notre requête
                    $query = sprintf($geocoder,$url_address);

                    // On interroge le serveur
                    $results = file_get_contents($query);

                    // On affiche le résultat
                    $movies = new SimpleXMLElement($results);

                    $ville[$i][0]=$movies->result[0]->geometry[0]->location[0]->lat;
                    $ville[$i][1]=$movies->result[0]->geometry[0]->location[0]->lng;
                    $i = $i+1;

                    echo "<div id=\"map\" style =\"height:100vh; width: 60vw\"></div>";


            };
        }

    }?>
    </tr>
    </table>


    <script>
      function initMap(<?php $ville ?>) {
        var point= {lat:  45.826474, lng: 1.261545};
        // Create a map object and specify the DOM element for display.
        var map = new google.maps.Map(document.getElementById('map'),{
          center: point,
          scrollwheel: true,
          zoom: 14,
        });
        <?php

         for ( $j = 0; $j <  count($ville)   ; $j++) {

             echo "var pointdecollecte= {lat: ".$ville[$j][0][0].", lng: ".$ville[$j][1][0]." };";
             echo "var Marker".$j ."= new google.maps.Marker({
                    map: map,
                    position: pointdecollecte ,
        


               });";
               /*var Marker = new google.maps.Marker({
                   map: map,
                   position : point,
               });
               var Marker2 = new google.maps.Marker({
                   map: map,
                   position : point2,
               });*/



       };
       ?>
    };
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCS7YM6Xo11hhqBf94DFmJ8rZUGNV7PrXM&callback=initMap"
    async defer></script>

<?php
};

if(isset($_SESSION["login"])){
  //Attention au nom de variable !!!
  ?>
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
    $_SESSION["numPointDeCollecteAModifier"]=$point->getPointNum();
    ?>
    <div id="ajouterArticle">
        <form class="modifier" method="POST" action="#">
            <label>Ville du point de collecte:</label>
            <input  type="text" name="VilleModifie" value="<?php echo $managerVille->getVilNomByNum($point->getPointVille())->getVilNom(); ?>" required>
            <br>
            <label>Visibilité:</label>
            <input name="visibilitePointDeCollecteModifier" type="radio" value="0" <?php if($point->getPointVisibilite()==0){echo "checked";}?>>non</input>
            <input name="visibilitePointDeCollecteModifier" type="radio" value="1"  <?php if($point->getPointVisibilite()==1){echo "checked";}?>>oui</input>
            <textarea name="lieuModifie" rows="8" required><?php echo $point->getPointLieu(); ?></textarea>
            <br>
            <input class="boutonModifierFinal" type="submit" value="Modifier le point de collecte">
        </form>
    </div>
<?php
}
?>
