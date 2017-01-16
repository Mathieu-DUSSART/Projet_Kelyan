<?php
class VilleManager{
	private $db;

	public function __construct($db){
		$this->db=$db;
  }

	public function getAllVille(){
		$tabObj=Array();
		$sql="SELECT * FROM ville ";
		$req=$this->db->query($sql);
		while($ligne=$req->fetch(PDO::FETCH_OBJ)){
			$tabObj[]=new Ville($ligne);
		}
		return $tabObj;
	}

	public function add($ville){
				$sql="INSERT INTO ville(vil_num,vil_nom) VALUES(:num,:nom)";
				$req=$this->db->prepare($sql);
				$req->bindValue(':num', $ville->getVilNum(), PDO::PARAM_INT);
				$req->bindValue(':nom', $ville->getVilNom(), PDO::PARAM_STR);
				$req->execute();
	}
}
?>
