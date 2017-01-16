<?php
class PointsdecollecteManager{
	private $db;

	public function __construct($db){
		$this->db=$db;
  }

    public function getAllPoint(){
  		$tabObj=Array();
  		$sql="SELECT * FROM Pointsdecollecte WHERE ";
  		$req=$this->db->query($sql);
  		while($ligne=$req->fetch(PDO::FETCH_OBJ)){
  			$tabObj[]=new Page($ligne);
  		}
  		return $tabObj;
  	}

    public function getPointByVille($nom){
  		$tabObj=Array();
  		$sql="SELECT * FROM Pointsdecollecte WHERE point_ville = :nom";
      $req=$this->db->prepare($sql);
      $req->bindValue(':num', $num, PDO::PARAM_INT);
      $req->execute();
  		while($ligne=$req->fetch(PDO::FETCH_OBJ)){
  			$tabObj[]=new Pointsdecollecte($ligne);
  		}
  		return $tabObj;
  	}

	}
