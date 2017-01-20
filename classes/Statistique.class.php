<?php
class Statistique {
  private $num;
  private $statistique;
  private $point;
  private $date;

  public function __construct($valeurs = array()){
    if(!empty($valeurs)){
      $this->affecte($valeurs);
    }
  }

  public function affecte($valeurs = array()){
    foreach($valeurs as $attribut => $donnee){
      switch($attribut){
        case "stat_num" : $this->setNum($donnee);
          break;
        case "statistique" : $this->setStatistique($donnee);
          break;
        case "point_num" : $this->setPoint($donnee);
          break;
        case "statistique_date" : $this->setDate($donnee);
          break;
      }
    }
  }

  public function setNum($num){
    $this->num = $num;
  }

  public function setStatistique($num){
    $this->statistique = $num;
  }

  public function getStatistique(){
    return $this->statistique;
  }

  public function getDate(){
    return $this->date;
  }

  public function getNum(){
    return $this->num;
  }

  public function setPoint($point){
    $this->point=$point;
  }

  public function getPoint(){
    return $this->point;
  }

  public function setDate($date){
    $this->date =$date ;
  }
}?>
