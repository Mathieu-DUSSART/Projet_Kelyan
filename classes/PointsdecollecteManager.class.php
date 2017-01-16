<?php
class PointsdecollecteManager{
	private $db;

	public function __construct($db){
		$this->db=$db;
  }

    public function getAllPoint(){
  		$tabObj=Array();
  		$sql="SELECT * FROM pointsdecollecte ";
  		$req=$this->db->query($sql);
  		while($ligne=$req->fetch(PDO::FETCH_OBJ)){
  			$tabObj[]=new Pointsdecollecte($ligne);
  		}
  		return $tabObj;
  	}

    public function getPointByVille($num){
  		$tabObj=Array();
  		$sql="SELECT * FROM pointdecollecte WHERE vil_num = :num";
      $req=$this->db->prepare($sql);
      $req->bindValue(':num', $num, PDO::PARAM_INT);
      $req->execute();
  		while($ligne=$req->fetch(PDO::FETCH_OBJ)){
  			$tabObj[]=new Pointsdecollecte($ligne);
  		}
  		return $tabObj;
  	}

    public function add($point){
          $sql="INSERT INTO pointdecollecte(point_num,point_lieu,vil_num,point_visibilite) VALUES(:num, :lieu, :ville, :visibilite)";
          $req=$this->db->prepare($sql);
          $req->bindValue(':num', $point->getNum(), PDO::PARAM_INT);
          $req->bindValue(':lieu', $point->getLieu(), PDO::PARAM_STR);
          $req->bindValue(':ville', $point->getVille(), PDO::PARAM_STR);
          $req->bindValue(':visibilite', $point->getVisibilite(), PDO::PARAM_STR);
          $req->execute();
  	}

    public function deletePoint($num){
      $sql="DELETE FROM pointsdecollecte WHERE point_num=:num";
      $req=$this->db->prepare($sql);
      $req->bindValue(':num', $num, PDO::PARAM_INT);
      $req->execute();
    }

		public function getAllLieux(){
			$sql="SELECT lieu FROM pointsdecollecte";
			$req=$this->db->query($sql);
			while($ligne=$req->fetch(PDO::FETCH_OBJ)){
				$tabObj[]=new Pointsdecollecte($ligne);
			}

			return $tabObj;
		}

	}
