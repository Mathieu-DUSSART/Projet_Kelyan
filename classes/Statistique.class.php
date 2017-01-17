<?php
class Statistique {
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
        case "statistique" : $this->setStatistique($donnee);
          break;
        case "point_num" : $this->setPoint($donnee);
          break;
        case "statistique_date" : $this->setDate($donnee);
          break;
      }
    }
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
