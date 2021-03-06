<?php
class PageManager{
	private $db;

	public function __construct($db){
		$this->db=$db;
	}

	/*
	Fonction qui récupère toutes les Pages de la BD qui doivent apparaitre dans la barre de navigation
	Paramètre : aucun
	Retourne : un tableau qui contient les Pages
	*/
	public function getAllPage(){
		$tabObj=Array();
		$sql="SELECT * FROM page WHERE page_hidden=0";
		$req=$this->db->query($sql);
		while($ligne=$req->fetch(PDO::FETCH_OBJ)){
			$tabObj[]=new Page($ligne);
		}
		return $tabObj;
	}

	/*
	Fonction qui récupère une Page de la BD en fonction de son numéro
	Paramètre :
		- $num : le numéro de la Page à récupérer
	Retourne : la Page qui correspond au numéro
	*/
	public function getPage($num){
		$sql="SELECT * FROM page WHERE page_num=:num";
		$req=$this->db->prepare($sql);
		$req->bindValue(':num', $num, PDO::PARAM_INT);
		$req->execute();
		$resu=$req->fetch(PDO::FETCH_OBJ);
		$page = new Page($resu);

		return $page;
	}
}
