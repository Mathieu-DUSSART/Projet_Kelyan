<?php
class GroupeManager{
	private $db;

	public function __construct($db){
		$this->db=$db;
	}

	public function getAllGroup(){
		$tabObj = Array();
		$sql="SELECT * FROM groupe";
		$req=$this->db->prepare($sql);
		$req->execute();
		while($ligne=$req->fetch(PDO::FETCH_OBJ)){
			$tabObj[]=new Groupe($ligne);
		}
		return $tabObj;

	}

	public function add($groupe){
		$sql="INSERT INTO `groupe` (group_nom) VALUES (:group_nom)";
		$req=$this->db->prepare($sql);
		$req->bindValue(':group_nom', $groupe->getGroupNom(), PDO::PARAM_STR);
		$req->execute();
	}

	public function deleteGroup($num){
		$sql="DELETE FROM groupe WHERE group_num=:num";
		$req=$this->db->prepare($sql);
		$req->bindValue(':num', $num, PDO::PARAM_INT);
		$req->execute();
	}

	public function getGroupByNum($num){
		$sql="SELECT * FROM groupe WHERE group_num=:num";
		$req=$this->db->prepare($sql);
		$req->bindValue(':num', $num, PDO::PARAM_INT);
		$req->execute();
		$res=$req->fetch(PDO::FETCH_OBJ);
		$group=new Groupe($res);

		return $group;
	}

	public function modifierGroupe($num,$nom)	{
		$sql="UPDATE groupe SET group_nom=:nom WHERE group_num=:num";
		$req=$this->db->prepare($sql);
		$req->bindValue(':num', $num, PDO::PARAM_INT);
		$req->bindValue(':nom', $nom, PDO::PARAM_STR);
		$req->execute();
	}
}
?>
