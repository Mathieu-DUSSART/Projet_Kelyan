<?php
class ContenuManager{
	private $db;

	public function __construct($db){
		$this->db=$db;
	}

  public function getAllContenu($num){
    $tabObj = Array();
    $sql="SELECT * FROM Contenu WHERE group_num = :num";
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

	public function deleteContenu($num){
		$sql="DELETE FROM contenu WHERE img_num=:num";
		$req=$this->db->prepare($sql);
		$req->bindValue(':num', $num, PDO::PARAM_INT);
		$req->execute();
	}


}
?>
