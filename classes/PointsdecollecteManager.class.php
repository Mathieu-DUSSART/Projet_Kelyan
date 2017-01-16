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
          $sql="INSERT INTO pointdecollecte(point_lieu,vil_num,point_visibilite) VALUES( :lieu, :ville, 0)";
          $req=$this->db->prepare($sql);
          $req->bindValue(':lieu', $point->getPointLieu(), PDO::PARAM_STR);
          $req->bindValue(':ville', $point->getPointVille(), PDO::PARAM_INT);
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


		public function modifierPointDeCollecte($point)	{
			$sql="UPDATE pointdecollecte SET vil_num=:ville, point_visibilite=:visibilite ,point_lieu=:lieu WHERE point_num=:num";
			$req=$this->db->prepare($sql);
			$req->bindValue(':lieu', $point->getPointLieu(), PDO::PARAM_STR);
			$req->bindValue(':ville', $point->getPointVille(), PDO::PARAM_STR);
			$req->bindValue(':visibilite', $point->getPointVisibilite(), PDO::PARAM_STR);
			$req->bindValue(':num', $point->getPointNum(), PDO::PARAM_INT);
			$req->execute();
		}

		public function deletePointDeCollecte($num){
			$sql="DELETE FROM pointdecollecte WHERE point_num=:num";
			$req=$this->db->prepare($sql);
			$req->bindValue(':num', $num, PDO::PARAM_INT);
			$req->execute();
		}

	}
