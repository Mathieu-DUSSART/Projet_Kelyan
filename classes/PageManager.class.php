<?php
class PageManager{
	private $db;

	public function __construct($db){
		$this->db=$db;
	}

	/*
	Fonction qui ajoute une page dans la BD
	Paramètre :
		- $page : la Page à ajouter
	Retourne : rien
	*/
	public function add($page){
        $sql="INSERT INTO page VALUES(:num, :nom, :hidden, :supprimable)";
        $req=$this->db->prepare($sql);
        $req->bindValue(':num', $page->getNum(), PDO::PARAM_INT);
        $req->bindValue(':nom', $page->getNom(), PDO::PARAM_STR);
		$req->bindValue(':hidden', $page->getHidden(), PDO::PARAM_INT);
		$req->bindValue(':supprimable', $page->getSupprimable(), PDO::PARAM_INT);
        $req->execute();
	}

	/*
	Fonction qui modifie une page de la BD
	Paramètre :
		- $page : la page à modifier
	*/
	public function modifierPage($page)	{
		$sql="UPDATE page SET page_nom=:page_nom WHERE page_num=:page_num";
		$req=$this->db->prepare($sql);
		$req->bindValue(':page_nom', $page->getNom(), PDO::PARAM_STR);
		$req->bindValue(':page_num', $page->getNum(), PDO::PARAM_INT);
		$req->execute();
	}

	/*
	Fonction qui supprime une Page de la BD en fonction de son numéro
	Paramètre :
		- $num : le numéro de la Page à supprimer
	Retourne : rien
	*/
	public function deletePage($num){
		$sql="DELETE FROM page WHERE page_num=:num";
		$req=$this->db->prepare($sql);
		$req->bindValue(':num', $num, PDO::PARAM_INT);
		$req->execute();
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

	public function estSupprimable($num){
			$sql='SELECT page_supprimable FROM page WHERE page_supprimable = 1 AND page_num = "'.$num.'"';
			$req = $this->db->query($sql);
			$resu = $req->fetch(PDO::FETCH_OBJ);
			if($resu != NULL){
				return true;
			}
			else {
				{
					return false;
				}
			}
		}
}
