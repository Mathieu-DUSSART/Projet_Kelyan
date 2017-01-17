<?php
class Video{
  private $num;
  private $src;
  private $nom;
  private $description;

  public function __construct($valeurs = array()){
      if(!empty($valeurs)){
          $this->affecte($valeurs);
      }
  }

  public function affecte($tab = array()){
  foreach($tab as $id => $valeurs){
    switch ($id){
      case 'video_num' : $this->setNum($valeurs);
        break;
      case 'video_src' : $this->setSrc($valeurs);
        break;
              case 'video_nom' : $this->setNom($valeurs);
        break;
              case 'video_description' : $this->setDescription($valeurs);
        break;
    }
  }
}

  public function setNum($num){
      $this->num=$num;
  }

  public function setSrc($src){
      $this->src=$src;
  }

  public function setNom($nom){
      $this->nom=$nom;
  }

  public function setDescription($description){
      $this->description=$description;
  }

  //-------------

  public function getNum(){
    return $this->num;
  }

  public function getSrc(){
      return $this->src;
  }

  public function getNom(){
    return $this->nom;
  }

  public function getDescription(){
    return $this->description;
  }
}
 ?>
