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
			$sql="INSERT INTO ville(vil_nom) VALUES(:nom)";
			$req=$this->db->prepare($sql);
			$req->bindValue(':nom', $ville, PDO::PARAM_STR);
			$req->execute();
		}

		public function existe($nom){
			$sql="SELECT * FROM ville WHERE vil_nom ='".$nom."' ";
			$req = $this->db->query($sql);
			$resu=$req->fetch(PDO::FETCH_OBJ);
			if($resu == NULL){
				return false;
			}else{
				return true;
			}
		}

		public function getVilNumByNom($nom){
			$sql="SELECT vil_num 	FROM 	ville WHERE vil_nom=:nom";
			$req = $this->db->prepare($sql);
			$req->bindValue(':nom', $nom, PDO::PARAM_STR);
			$req->execute();
			$ligne=$req->fetch(PDO::FETCH_OBJ);
			$obj=new Ville($ligne);
			return $obj;
		}

		public function getVilNomByNum($num){
			$sql="SELECT vil_nom 	FROM 	ville WHERE vil_num=:num";
			$req = $this->db->prepare($sql);
			$req->bindValue(':num', $num, PDO::PARAM_INT);
			$req->execute();
			$ligne=$req->fetch(PDO::FETCH_OBJ);
			$obj=new Ville($ligne);
			return $obj;
		}

		public function delete($num){
			$sql="DELETE FROM  Ville where vil_num =:num";
			$req = $this->db->prepare($sql);
			$req->bindValue(':num', $num, PDO::PARAM_INT);
			$req->execute();
		}
	}
	?>
