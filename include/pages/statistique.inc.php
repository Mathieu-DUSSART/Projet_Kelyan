<h1>Statistique</h1>

<?php
$anneeActuel=2017;
//Listage des statistique par Point de Collecte
$tabVille = $managerVille->getAllVille();
if(isset($_POST["selectVillePoint"] ) || isset($_SESSION["Numville"])){
    if((isset($_POST["selectVillePoint"]))){
        if( $_SESSION["Numville"]!=$_POST["selectVillePoint"]){
            $_SESSION["Numville"]=$_POST["selectVillePoint"];
        }
    }else{
        if (!isset($_SESSION["Numville"])){
        //    $_SESSION["Numville"]=$_POST["selectVillePoint"];
        }
    }
}

$villeTab = array();
$villeTab = $managerVille->getAllVille();?>
<div id="divChoixVillePoint">
    <form action="#" method="POST">
        <label>Ville : </label>
        <select name="selectVillePoint">
            <?php
            if(isset($_POST["selectVillePoint"] ) || isset($_SESSION["Numville"])){
                echo "<option value=\"" . $_SESSION["Numville"]. "\" selected=\"selected\">" . $managerVille->getVilNomByNum($_SESSION["Numville"])->getVilNom() . "</option>";
            }
            foreach($villeTab as $ville){
                echo "<option value=\"" . $ville->getVilNum() . "\">" . $ville->getVilNom() . "</option>";
            }?>
        </select>
        <input type="submit" value="Valider">
        <div id="choixVue">
            <form action="#" method="POST">
                <input type=radio name="choixVue" value="annee" checked>Année
                <input type=radio name="choixVue" value="mois">Mois
                <input type=radio name="choixVue" value="total">Total
                <input type=radio name="choixVue" value="test">Test
                <input type="submit" value="Valider">
            </form>
        </div>
    </form>
</div>

<?php
if(isset($_POST["selectVillePoint"])){
    switch ($_POST["choixVue"]) {
        case 'mois':
            echo "<h2> Vue par mois </h2>";
            $Mois = array(
                array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre"),
                array("","","","","","","","","","","",""),
            );
            $anneeActuel=2017;
            echo "nombre anneé :";
            echo $managerStatistique->getNbAnneeStat();
            echo "<table>";

            for ($j=0;$j<$managerStatistique->getNbAnneeStat();$j++){
                echo "<tr>";
                echo "<td>";
                echo $anneeActuel-$j;
                echo "</td>";

                for ($i=1;$i<13;$i++){
                    echo "<td>";
                    echo $managerStatistique->getStateParMois($i,$anneeActuel-$j);
                    echo $Mois[0][$i-1];
                    echo "</td>";

                }
                echo "</tr>";

            }
            echo "</table>";
            echo "<br>";
        break;

        case 'total':
            $AllPoint = array();
            $AllPoint = $managerPointsDeCollecte->getPointByVille($_SESSION["Numville"]);
            $ville=$managerVille->getVilNomByNum($_SESSION["Numville"])->getVilNom();
            echo "<h2>".$ville."</h2>";
            foreach ($AllPoint as $point) {
                echo "<blockquote> <h3>". $point->getPointLieu() . " : </h3></blockquote>";
                $tabStatistique=$managerStatistique->getStatistiqueByPoint($point->getPointNum());
                foreach ($tabStatistique as $stat) {
                    $dateEvent=date_create($stat->getDate());
                    //Récupère le nom du mois en fonction de son numéro
                    $mois=getMois(date_format($dateEvent, 'm'));
                    //Récupère la date de l'évènement au format 23 Septembre 2016
                    $date = date_format($dateEvent, 'd ') . $mois . date_format($dateEvent, ' Y');
                    echo "<dd> <p> statistique du ".$date." nombre de bouchons récoltés : " . $stat->getStatistique() . "</p>";
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
            break;

        case 'annee':

        echo "<table>";

        for ($j=0;$j<$managerStatistique->getNbAnneeStat();$j++){
            echo "<tr>";
            echo "<td>";
            echo "annee : ";
            echo $anneeActuel-$j;
            echo "</td>";
            echo "<td>";
            echo $managerStatistique->getStateParAnnee(($anneeActuel-$j));
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";

        break;

        case 'test':

        $anneeActuel=2017;
        echo "nombre anneé :";
        echo $managerStatistique->getNbAnneeStat();
                echo "<table>";
                for ($j=0;$j<$managerStatistique->getNbAnneeStat();$j++){

                    echo "<tr>";
                    echo "<td>";
                    echo "annee : ";
                    echo $anneeActuel-$j;
                    echo "</td>";
                    echo "<td>";
                    echo $managerStatistique->getStateParAnnee(($anneeActuel-$j));
                    echo "</td>";
                    echo "<td>";
                    ?>
                    <form class="modifierPointDeCollecte" method="POST" action="#">
                      <input name="PlusDeDetail" type="submit" value="M">
                      <input class="numModif" name="AnneePlusDetail" type="hidden" value="<?php echo $anneeActuel-$j;?>">
                    </form>
                    <?php
                    echo "</td>";
                    echo "</tr>";

                }
                echo "</table>";
                break;


}
}
    if (isset($_POST['PlusDeDetail'])){

    $Mois = array(
    array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre"),
    array("","","","","","","","","","","",""),
    );
    echo "<table>";

    for ($i=1;$i<13;$i++){
        echo "<tr>";
        echo "<td>";
        echo $managerStatistique->getStateParMois($i,$_POST['AnneePlusDetail']);
        echo $Mois[0][$i-1];
        echo "</td>";
        echo "<td>";
        ?>
        <form class="modifierPointDeCollecte" method="POST" action="#">
          <input name="PlusDeDetailMois" type="submit" value="M">
          <input class="numModif" name="AnneePointPlusDetail" type="hidden" value="<?php echo $_POST['AnneePlusDetail'];?>">
           <input class="numModif" name="MoisPlusDetail" type="hidden" value="<?php echo $i;?>">
        </form>
        <?php
        echo "</td>";
        echo "</tr>";

    }

    echo "</table>";
    echo "<br>";

}

    if (isset($_POST['PlusDeDetailMois'])){

            $numPoint = $managerPointsDeCollecte->getPointByStatistique($_POST['MoisPlusDetail'],$_POST['AnneePointPlusDetail']);
            $point = $managerPointsDeCollecte->getPointByNum($numPoint->getPointNum());
            $ville=$managerPointsDeCollecte->getVilleParPointNum($point->getPointNum());
            $villeNom=$managerVille->getVilNomByNum($ville->getPointVille());
            echo "<h2>".$villeNom->getVilNom()."</h2>";
            echo "<blockquote> <h3>". $point->getPointLieu() . " : </h3></blockquote>";
            $tabStatistique=$managerStatistique->getStatistiqueByPoint($point->getPointNum());
            foreach ($tabStatistique as $stat) {
                $dateEvent=date_create($stat->getDate());
                //Récupère le nom du mois en fonction de son numéro
                $mois=getMois(date_format($dateEvent, 'm'));
                //Récupère la date de l'évènement au format 23 Septembre 2016
                $date = date_format($dateEvent, 'd ') . $mois . date_format($dateEvent, ' Y');
                echo "<dd> <p> statistique du ".$date." nombre de bouchons récoltés : " . $stat->getStatistique() . "</p>";
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
  $managerStatistique->modifierStatistique($_POST["valeurStatistiqueModif"],$_POST["selectPointModif"],getEnglishDate($_POST["dateModif"]),$_POST["numStatistiqueModif"]);
  header("Location: index.php?page=10");

}
 ?>
