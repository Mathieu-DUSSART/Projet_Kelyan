<?php

class PersonneManager{
	private $db;

	public function __construct($db){
		$this->db = $db;
	}

  public function add($personne){
    $sql = "INSERT INTO personne(per_nom, per_prenom, per_mail) VALUES(:per_nom, :per_prenom, :per_mail);";
    $req=$this->db->prepare($sql);
    $req-> bindValue(':per_nom',$personne->getPerNom(), PDO::PARAM_STR);
    $req-> bindValue(':per_prenom',$personne->getPerPrenom(), PDO::PARAM_STR);
    $req-> bindValue(':per_mail',$personne->getPerMail(), PDO::PARAM_STR);
    $req->execute();

    $sqlNumPers="SELECT LAST_INSERT_ID() as per_num";
    $reqNumPers=$this->db->query($sqlNumPers);
    $res=$reqNumPers->fetch(PDO::FETCH_OBJ);
    $personne->setPerNum($res->per_num);
  }

  public function ajouterUneInscription($personneinscrite,$numEvent){
    $sql = "INSERT INTO inscritevent(per_num, event_num) VALUES(:per_num, :event_num);";
    $req=$this->db->prepare($sql);
    $req-> bindValue(':per_num',$personneinscrite, PDO::PARAM_INT);
    $req-> bindValue(':event_num',$numEvent, PDO::PARAM_INT);
    $req->execute();
  }

public function getPersonneInscriteEvent($num_event){
  $tabObj = array();
  $sql="SELECT per_nom, per_prenom, per_mail FROM personne p JOIN inscritevent i ON p.per_num=i.per_num WHERE event_num = $num_event";
  $req=$this->db->prepare($sql);
  $req->execute();
  while($ligne=$req->fetch(PDO::FETCH_OBJ)){
    $tabObj[]=new Personne($ligne);
  }
  return $tabObj;
}
}
