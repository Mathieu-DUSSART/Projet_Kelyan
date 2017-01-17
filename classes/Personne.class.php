<?php
class Personne{
  	private $per_num;
    private $per_nom;
    private $per_prenom;
    private $per_mail;
    private $per_inscrit_news;

    public function __construct($valeurs = array()){
    if(!empty($valeurs)){
      $this->affecte($valeurs);
    }
  }
  public function affecte($valeurs){
    foreach($valeurs as $attribut => $valeur){
      switch($attribut){
        case 'per_num' : $this->setPerNum($valeur);
        break;
        case 'per_nom' : $this->setPerNom($valeur);
        break;
        case 'per_prenom' : $this->setPerPrenom($valeur);
        break;
        case 'per_mail' : $this->setPerMail($valeur);
        break;
        case 'per_inscrit_news' : $this->setInscritNews($valeur);
      }
    }
  }

  public function setPerNum($per_num){
    $this->per_num=$per_num;
  }

  public function getPerNum(){
    return $this->per_num;
  }

  public function setPerNom($per_nom){
      $this->per_nom = $per_nom;
  }

  public function getPerNom(){
    return $this->per_nom;
  }

  public function setPerPrenom($per_prenom){
      $this->per_prenom = $per_prenom;
  }

  public function getPerPrenom(){
    return $this->per_prenom;
  }

  public function setPerMail($per_mail){
    $this->per_mail = $per_mail;

  }

  public function getPerMail(){
    return $this->per_mail;
  }

  public function setInscritNews($per_inscrit_news){
    $this->per_inscrit_news = $per_inscrit_news;
  }

  public function getPerInscritNews(){
    return $this->per_inscrit_news;
  }
}
