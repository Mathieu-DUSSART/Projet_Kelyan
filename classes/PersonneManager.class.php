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

  public function existe($mail){
    $sql="SELECT * FROM personne WHERE per_mail=:mail";
    $req = $this->db->prepare($sql);
    $req-> bindValue(':mail',$mail, PDO::PARAM_STR);
    $req->execute();
    $resu=$req->fetch(PDO::FETCH_OBJ);
    return isset($resu->per_num);
  }

  public function dejaInscrit($per_num, $event_num){
    $sql="SELECT * FROM inscritevent WHERE per_num =:per_num AND event_num=:event";
    $req = $this->db->prepare($sql);
    $req-> bindValue(':per_num',$per_num, PDO::PARAM_INT);
    $req-> bindValue(':event',$event_num, PDO::PARAM_INT);
    $req->execute();
    $resu=$req->fetch(PDO::FETCH_OBJ);
    return isset($resu->per_num);
  }

	public function getPersonne($mail){
		$sql = "SELECT * FROM personne WHERE per_mail=:mail";
		$req=$this->db->prepare($sql);
		$req-> bindValue(':mail',$mail, PDO::PARAM_STR);
		$req->execute();
		$resu = $req->fetch(PDO::FETCH_OBJ);
		$personne = new Personne($resu);

		return $personne;
	}


	public function getPersonneInscriteEvent($num_event){
		$tabObj = array();
		$sql="SELECT per_nom, per_prenom, per_mail FROM personne p JOIN inscritevent i ON p.per_num=i.per_num WHERE event_num = :num_event";
		$req=$this->db->prepare($sql);
		$req->bindValue(':num_event', $num_event, PDO::PARAM_INT);
		$req->execute();
		while($ligne=$req->fetch(PDO::FETCH_OBJ)){
			$tabObj[]=new Personne($ligne);
		}
		return $tabObj;
	}

	public function getNbPersonneInscrite($num_event){
		$sql = "SELECT COUNT(*) AS nbPersonne FROM inscritevent WHERE event_num=:num_event";
		$req = $this->db->prepare($sql);
		$req->bindValue(':num_event', $num_event, PDO::PARAM_INT);
		$req->execute();
		$ligne = $req->fetch(PDO::FETCH_OBJ);
		return $ligne->nbPersonne;
	}

	public function personneDejaInscriteNews($personne){
		$sql="SELECT per_inscrit_news FROM personne WHERE per_num=:num";
		$req=$this->db->prepare($sql);
		$req->bindValue(':num', $personne->getPerNum(), PDO::PARAM_INT);
		$req->execute();
		$resu=$req->fetch(PDO::FETCH_OBJ);

		return $resu->per_inscrit_news;
	}

	public function inscrireNews($personne){
		$sql="UPDATE personne SET per_inscrit_news = 1 WHERE per_num= :num";
		$req=$this->db->prepare($sql);
		$req->bindValue(':num', $personne->getPerNum(), PDO::PARAM_INT);
		$req->execute();
	}

	public function setCle($mail,$cle){
		$sql="UPDATE personne SET per_cle= :cle WHERE per_mail= :mail";
		$req=$this->db->prepare($sql);
		$req->bindValue(':mail',$mail,PDO::PARAM_STR);
		$req->bindValue(':cle',$cle,PDO::PARAM_STR);
		$req->execute();
	}

	public function deletePersonneInscrit($event){
		$sql = "DELETE FROM inscritevent WHERE event_num = :event";
		$req=$this->db->prepare($sql);
		$req->bindValue(':event',$event,PDO::PARAM_INT);
		$req->execute();
	}
}
