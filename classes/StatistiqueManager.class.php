<?php
class StatistiqueManager{
  private $db;

  public function __construct($db){
    $this->db=$db;
  }

  public function add($statistique){
    $sql="INSERT INTO statistique(statistique,point_num,statistique_date) VALUES(:stat,:pointCollecte,:stat_date)";
    $req=$this->db->prepare($sql);
    $req->bindValue(":stat", $statistique->getStatistique(),PDO::PARAM_STR);
    $req->bindValue(":pointCollecte", $statistique->getPoint(),PDO::PARAM_INT);
    $req->bindValue(":stat_date", $statistique->getDate(),PDO::PARAM_STR);
    $req->execute();
  }

  public function getStatistiqueByPoint($num){
    $tabObj = array();
    $sql="SELECT * FROM statistique WHERE point_num = :num";
    $req=$this->db->prepare($sql);
    $req->bindValue(":num", $num,PDO::PARAM_INT);
    $req->execute();
    while($ligne=$req->fetch(PDO::FETCH_OBJ)){
      $tabObj[] = new Statistique($ligne);
    }
    return $tabObj;
  }

  public function getStatistiqueByNum($num){
    $sql="SELECT * FROM statistique WHERE stat_num = :num";
    $req=$this->db->prepare($sql);
    $req->bindValue(":num", $num,PDO::PARAM_INT);
    $req->execute();
    while($ligne=$req->fetch(PDO::FETCH_OBJ)){
      $tabObj = new Statistique($ligne);
    }
    return $tabObj;
  }

  public function deleteStatistique($stat){
    $sql="DELETE FROM statistique WHERE stat_num=:stat_num";
    $req=$this->db->prepare($sql);
    $req->bindValue(":stat_num", $stat,PDO::PARAM_INT);
    $req->execute();
  }

  public function modifierStatistique($statistique,$point_num,$dateStat,$stat_num)	{
		$sql="UPDATE statistique SET statistique=:statistique ,point_num=:point_num , statistique_date=:dateStat  WHERE stat_num=:stat_num ";
		$req=$this->db->prepare($sql);
		$req->bindValue(':statistique', $statistique, PDO::PARAM_STR);
		$req->bindValue(':point_num', $point_num, PDO::PARAM_INT);
    $req->bindValue(':dateStat', $dateStat, PDO::PARAM_STR);
    $req->bindValue(':stat_num', $stat_num, PDO::PARAM_INT);
		$req->execute();
	}
    public function getStateParMois($mois,$annee){
        $sql="SELECT sum(statistique) as nbStat FROM statistique WHERE MONTH(statistique_date)=:mois and year(statistique_date)=:annee";
        $req=$this->db->prepare($sql);
        $req->bindValue(":mois", $mois ,PDO::PARAM_INT);
        $req->bindValue(":annee", $annee ,PDO::PARAM_INT);
        $req->execute();

        if($req->nbstat!=NULL){
            return $req->nbstat;
        }else{
            return 0;
        }
    }

}

 ?>
