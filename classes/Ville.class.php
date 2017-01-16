<?php
class Ville{
  private $vilnum;
  private $vilnom;

  public function __construct($values = array()){
    if(!empty($valeurs)){
        $this->affecte($valeurs);
    }
  }

  public function affecte($tab = array()){
  foreach($tab as $id => $valeurs){
    switch ($id){
      case 'vil_num' : $this->setVilNum($valeurs);
        break;
      case 'vil_nom' : $this->setVilNom($valeurs);
        break;
      }
    }
  }

  public function getVilNum(){
    return $this->vilnum;
  }

  public function setVilNum($num){
    $this->vilnum=$num;
  }

  public function getVilNom(){
    return $this->vilnom;
  }

  public function setVilNom($nom){
    $this->vilnom=$nom;
  }

}
 ?>
