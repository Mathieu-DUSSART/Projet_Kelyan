<?php
public class Statistique {
  private $statistique;

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
      }
    }
  }

  public function setStatistique($num){
    $this->statistique = $num;
  }
}?>
