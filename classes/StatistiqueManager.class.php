<?php
class StatistiqueManager{
  private $db;

  public function __construct($db){
    $this->db=$db;
  }

  public function add($statistique){
    $sql="INSERT INTO statistique VALUES(:num, :pointCollecte,:stat_date)";
    $req=$this->db->prepare($sql);
    $req->bindValue(":num", $statistique->getStatistique(),PDO::PARAM_STR);
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

  public function deleteStatistique($stat){
    $sql="DELETE FROM statistique WHERE statistique_date=:dateStat AND statistique=:stat AND point_num =:point_num";
    $req=$this->db->prepare($sql);
    $req->bindValue(":dateStat", $stat->getDate(),PDO::PARAM_STR);
    $req->bindValue(":stat", $stat->getStatistique(),PDO::PARAM_STR);
    $req->bindValue(":point_num", $stat->getPoint(),PDO::PARAM_INT);
    $req->execute();
  }
}
 ?>
