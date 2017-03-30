<?php

require_once("include/config.inc.php");
require_once("include/autoLoad.inc.php");
require_once("include/function.inc.php");

$pdo=new Mypdo();
$managerStatistique = new StatistiqueManager($pdo);

$tab = array();

if(isset($_GET["annee"])){
    for($i=1;$i<13;$i++){
        $statistiqueMois = $managerStatistique->getStateParMois($i,$_GET["annee"]);
        $tab[] = [ 'id' => $i,'mois'=>1,'annee'=>0,'pointCollecte'=>0, 'stat' => $statistiqueMois ];
    }
}


for ($j=0;$j<$managerStatistique->getNbAnneeStat();$j++){
        $statistiqueAnnee= $managerStatistique->getStateParAnnee((2017-$j));
        $tab[] = [ 'id' => 2017-$j,'mois'=>0,'annee'=>1,'pointCollecte'=>0, 'stat' => $statistiqueAnnee ];
}
//$statistiqueMois = $managerStatistique->getStateParMois(1,2017);

//$tab[] = [ 'stat_mois' => $statistiqueMois ];

echo json_encode($tab);

?>
