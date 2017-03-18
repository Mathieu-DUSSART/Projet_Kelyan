<?php
class ContenuManager{
	private $db;

	public function __construct($db){
		$this->db=$db;
	}

	public function getAllContenu($num){
		$tabObj = Array();
		$sql="SELECT * FROM contenu WHERE group_num = :num";
		$req=$this->db->prepare($sql);
		$req->bindValue(":num", $num, PDO::PARAM_INT);
		$req->execute();
		while($ligne=$req->fetch(PDO::FETCH_OBJ)){
			$tabObj[]=new Contenu($ligne);
		}
		return $tabObj;
	}

	public function add($contenu){
		$sql="INSERT INTO contenu VALUES (:group_num,:img_num)";
		$req=$this->db->prepare($sql);
		$req->bindValue(':group_num', $contenu->getGroupNum(), PDO::PARAM_INT);
		$req->bindValue(':img_num', $contenu->getImgNum(), PDO::PARAM_INT);
		$req->execute();
	}

	public function deleteContenu($groupNum, $imgNum){
		$sql="DELETE FROM contenu WHERE group_num = :groupNum AND img_num= :imgNum";
		$req=$this->db->prepare($sql);
		$req->bindValue(':groupNum', $groupNum, PDO::PARAM_INT);
		$req->bindValue(':imgNum', $imgNum, PDO::PARAM_INT);
		$req->execute();
	}

	public function getImgDuGroupe($numGroupe){
		$sql = "SELECT img_num FROM contenu WHERE group_num = :numGroupe";
		$req = $this->db->prepare($sql);
		$req->bindValue(':numGroupe', $numGroupe, PDO::PARAM_INT);
		$req->execute();

		$tabImg = Array();
		while($ligne = $req->fetch(PDO::FETCH_OBJ)){
			$tabImg[] = new Image($ligne);
		}
		return $tabImg;
	}

}
?>
