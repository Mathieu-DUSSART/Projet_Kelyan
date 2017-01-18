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
}
?>
