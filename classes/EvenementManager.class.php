<?php
class EvenementManager{
	private $db;

	public function __construct($db){
		$this->db=$db;
	}

	/*
	Fonction qui ajoute un Evènement dans la BD
	Paramètre :
		- $event : l'Evènement à ajouter
	Retourne : rien
	*/
	public function add($event){
        $sql="INSERT INTO evenement(event_titre, event_date, event_heure, event_texte, event_ville, point_num) VALUES(:titre, :dateEvent, :heure, :texte, :ville, :pointNum)";
        $req=$this->db->prepare($sql);
        $req->bindValue(':titre', $event->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':dateEvent', $event->getDate(), PDO::PARAM_STR);
        $req->bindValue(':heure', $event->getHeure(), PDO::PARAM_STR);
        $req->bindValue(':texte', $event->getTexte(), PDO::PARAM_STR);
        $req->bindValue(':ville', $event->getVille(), PDO::PARAM_STR);
		$req->bindValue(':pointNum', $event->getPointNum(), PDO::PARAM_INT);
        $req->execute();
	}

	/*
	Fonction qui supprime un Evènement de la BD en fonction de son numéro
	Paramètre :
		- $num : le numéro de l'Evènement à supprimer
	Retourne : rien
	*/
	public function deleteEvenement($num){
		$sql="DELETE FROM evenement WHERE event_num=:num";
		$req=$this->db->prepare($sql);
		$req->bindValue(':num', $num, PDO::PARAM_INT);
		$req->execute();
	}

	public function modifierEvenement($event){
        $sql="UPDATE evenement SET event_titre=:titre, event_date=:dateEvent, event_heure=:heure, event_texte=:texte, event_ville=:ville, point_num=:pointNum WHERE event_num=:num";
        $req=$this->db->prepare($sql);
        $req->bindValue(':titre', $event->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':dateEvent', $event->getDate(), PDO::PARAM_STR);
        $req->bindValue(':heure', $event->getHeure(), PDO::PARAM_STR);
        $req->bindValue(':texte', $event->getTexte(), PDO::PARAM_STR);
        $req->bindValue(':ville', $event->getVille(), PDO::PARAM_STR);
		$req->bindValue(':pointNum', $event->getPointNum(), PDO::PARAM_INT);
		$req->bindValue(':num', $event->getNum(), PDO::PARAM_INT);
        $req->execute();
	}

	/*
	Fonction qui permet de récupérer tous les Evènements de la BD
	Paramètre : aucun
	Retourne : un tableau qui contient tous les Evènements
	*/
	public function getAllEvenement(){
		$tabObj=Array();
		$sql="SELECT * FROM evenement ORDER BY event_date DESC, event_heure DESC";
		$req=$this->db->prepare($sql);
        $req->execute();
		while($ligne=$req->fetch(PDO::FETCH_OBJ)){
			$tabObj[]=new Evenement($ligne);
		}
		return $tabObj;
	}
}
?>
