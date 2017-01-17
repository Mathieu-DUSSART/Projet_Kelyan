<?php
class VideoManager{
  private $db;

	public function __construct($db){
		$this->db=$db;
	}

	/*
	Fonction qui ajoute une video dans la BD
	Paramètre :
		- $image : la video à ajouter
	Retourne : rien
	*/
	public function add($video){
        $sql="INSERT INTO video(video_src, video_nom, video_description) VALUES(:src, :nom, :description)";
        $req=$this->db->prepare($sql);
        $req->bindValue(':src', $video->getSrc(), PDO::PARAM_STR);
        $req->bindValue(':nom', $video->getNom(), PDO::PARAM_STR);
        $req->bindValue(':description', $video->getDescription(), PDO::PARAM_STR);
        $req->execute();
	}

	/*
	Fonction qui supprime une Image de la BD en fonction de son numéro
	Paramètre :
		- $num : le numéro de l'Image à supprimer
	Retourne : rien
	*/
	public function deleteVideo($num){
		$sql="DELETE FROM video WHERE video_num=:num";
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
    public function getAllVideo($src){
        $tabObj=Array();
        $sql="SELECT * FROM video WHERE video_src= :src";
        $req=$this->db->prepare($sql);
        $req->bindValue(':src', $src, PDO::PARAM_STR);
        $req->execute();
        while($ligne=$req->fetch(PDO::FETCH_OBJ)){
            $tabObj[]=new Video($ligne);
		}
		return $tabObj;
    }

	/*
	Fonction qui permet de récupérer une Image de la BD en fonction de son numéro
	Paramètre :
		- $num : le numéro de l'Image à récupérer
	Retourne : l'Image qui correspond au numéro
	*/
	public function getVideo($num){
		$sql="SELECT * FROM video WHERE img_num=:num";
		$req=$this->db->prepare($sql);
        $req->bindValue(':num', $num, PDO::PARAM_INT);
        $req->execute();
		$res=$req->fetch(PDO::FETCH_OBJ);
		$video=new Video($res);

		return $video;
	}
}
 ?>
