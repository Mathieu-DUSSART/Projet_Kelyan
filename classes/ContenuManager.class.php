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


}
?>
