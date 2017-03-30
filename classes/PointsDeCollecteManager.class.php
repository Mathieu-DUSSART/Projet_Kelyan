<?php
class PointsDeCollecteManager{
		private $db;

		public function __construct($db){
			$this->db=$db;
	  }

    public function getAllPoint(){
  		$tabObj=Array();
  		$sql="SELECT * FROM pointdecollecte ";
  		$req=$this->db->query($sql);
  		while($ligne=$req->fetch(PDO::FETCH_OBJ)){
  			$tabObj[]=new PointsDeCollecte($ligne);
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
  			$tabObj[]=new PointsDeCollecte($ligne);
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
      $sql="DELETE FROM pointdecollecte WHERE point_num=:num";
      $req=$this->db->prepare($sql);
      $req->bindValue(':num', $num, PDO::PARAM_INT);
      $req->execute();
    }

		public function getAllLieux(){
			$sql="SELECT lieu FROM pointdecollecte";
			$req=$this->db->query($sql);
			while($ligne=$req->fetch(PDO::FETCH_OBJ)){
				$tabObj[]=new PointsDeCollecte($ligne);
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

		public function getNbLieuParVille($num){
			$sql = "SELECT count(point_lieu)as nbLieu FROM pointdecollecte WHERE vil_num=:num ";
			$req=$this->db->prepare($sql);
			$req->bindValue(':num', $num, PDO::PARAM_INT);
			$req->execute();
      $resu = $req->fetch(PDO::FETCH_OBJ);
      if($resu != NULL){
        return $resu->nbLieu;
      }
    }


		public function getVilleParPointNum($num){
			$sql="SELECT vil_num FROM pointdecollecte WHERE point_num = :num";
			$req=$this->db->prepare($sql);
			$req->bindValue(':num', $num, PDO::PARAM_INT);
			$req->execute();
			$res=$req->fetch(PDO::FETCH_OBJ);
			$obj=new PointsDeCollecte($res);
			return $obj;
		}

		public function getLieuByPointNum($num){
			$sql="SELECT point_lieu FROM pointdecollecte WHERE point_num = :num";
			$req=$this->db->prepare($sql);
			$req->bindValue(':num', $num, PDO::PARAM_INT);
			$req->execute();
			$res=$req->fetch(PDO::FETCH_OBJ);
			$obj=new PointsDeCollecte($res);
			return $obj;

	}


	public function getPointByNum($num){
		$sql="SELECT * FROM pointdecollecte WHERE point_num = :num";
		$req=$this->db->prepare($sql);
		$req->bindValue(':num', $num, PDO::PARAM_INT);
		$req->execute();
		$res=$req->fetch(PDO::FETCH_OBJ);
		$obj=new PointsDeCollecte($res);
		return $obj;

}

	public function getPointByStatistique($month,$annee){
	  $sql="SELECT s.point_num FROM pointdecollecte p INNER JOIN statistique s ON s.point_num=p.point_num WHERE MONTH(statistique_date)=:mois and year(statistique_date)=:annee ";
	  $req=$this->db->prepare($sql);
	  $req->bindValue(":mois", $month ,PDO::PARAM_STR);
	  $req->bindValue(":annee", $annee ,PDO::PARAM_STR);
	  $req->execute();
	  $res=$req->fetch(PDO::FETCH_OBJ);
	  $obj=new PointsDeCollecte($res);
	  return $obj;
	}


	public function existe($nom){
		$sql="SELECT * FROM pointdecollecte WHERE point_lieu =\"".$nom."\"";
		echo $sql;
		$req = $this->db->query($sql);
		$resu=$req->fetch(PDO::FETCH_OBJ);
		if($resu == NULL){
			return false;
		}else{
			return true;
		}
	}


	public function getNbLieuVisibleParVille($num){
		$sql = "SELECT count(point_lieu)as nbLieu FROM pointdecollecte WHERE vil_num=:num and point_visibilite=1";
		echo $sql;
		$req=$this->db->prepare($sql);
		$req->bindValue(':num', $num, PDO::PARAM_INT);
		$req->execute();
		$resu = $req->fetch(PDO::FETCH_OBJ);
		echo $resu->nbLieu;
	 	if($resu != NULL){
			return $resu->nbLieu;
	  	}
	}
}
