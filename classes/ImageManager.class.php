<?php
class ImageManager{
	private $db;

	public function __construct($db){
		$this->db=$db;
	}

	/*
	Fonction qui ajoute une Image dans la BD
	Paramètre :
		- $image : l'Image à ajouter
	Retourne : rien
	*/
	public function add($image){
        $sql="INSERT INTO image(img_src, img_nom, img_description, img_lien,img_type) VALUES(:src, :nom, :description, :lien,:type)";
        $req=$this->db->prepare($sql);
        $req->bindValue(':src', $image->getSrc(), PDO::PARAM_STR);
        $req->bindValue(':nom', $image->getNom(), PDO::PARAM_STR);
        $req->bindValue(':description', $image->getDescription(), PDO::PARAM_STR);
        $req->bindValue(':lien', $image->getLien(), PDO::PARAM_STR);
				$req->bindValue(':type', $image->getType(), PDO::PARAM_INT);
        $req->execute();
	}

	/*
	Fonction qui supprime une Image de la BD en fonction de son numéro
	Paramètre :
		- $num : le numéro de l'Image à supprimer
	Retourne : rien
	*/
	public function deleteImage($num){
		$sql="DELETE FROM image WHERE img_num=:num";
		$req=$this->db->prepare($sql);
		$req->bindValue(':num', $num, PDO::PARAM_INT);
		$req->execute();
	}

	/*
	Fonction qui permet de récupérer toutes les Images de la BD qui ont le chemin d'accès fourni en paramètre
	Paramètre :
		- $src : le chemin d'accès de l'image
	Retourne : un tableau qui contient les Images récupérées par la requête
	*/
    public function getAllImage($src){
        $tabObj=Array();
        $sql="SELECT * FROM image WHERE img_src= :src";
        $req=$this->db->prepare($sql);
        $req->bindValue(':src', $src, PDO::PARAM_STR);
        $req->execute();
        while($ligne=$req->fetch(PDO::FETCH_OBJ)){
            $tabObj[]=new Image($ligne);
		}
		return $tabObj;
    }


	/*
	Fonction qui permet de récupérer une Image de la BD en fonction de son numéro
	Paramètre :
		- $num : le numéro de l'Image à récupérer
	Retourne : l'Image qui correspond au numéro
	*/
	public function getImage($num){
		$sql="SELECT * FROM image WHERE img_num=:num";
		$req=$this->db->prepare($sql);
        $req->bindValue(':num', $num, PDO::PARAM_INT);
        $req->execute();
		$res=$req->fetch(PDO::FETCH_OBJ);
		$image=new Image($res);

		return $image;
	}

	public function getImageByNom($nom){
		$sql = "SELECT img_num FROM image WHERE img_nom=:nom";
		$req=$this->db->prepare($sql);
		$req->bindValue(':nom', $nom, PDO::PARAM_STR);
		$req->execute();
		$resu = $req->fetch(PDO::FETCH_OBJ);
		if($resu != NULL){
			return $resu->img_num;
		}
	}
}
?>
