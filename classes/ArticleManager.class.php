<?php
class ArticleManager{
	private $db;

	public function __construct($db){
		$this->db=$db;
	}

	/*
	Fonction qui ajoute un Article dans la BD
	Paramètre :
		- $article : l'Article à ajouter
	Retourne : rien
	*/
	public function add($article){
        $sql="INSERT INTO article(art_titre, art_date, art_texte, page_num) VALUES(:titre, :dateArt, :texte, :pageNum)";
        $req=$this->db->prepare($sql);
        $req->bindValue(':titre', $article->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':dateArt', $article->getDate(), PDO::PARAM_STR);
        $req->bindValue(':texte', $article->getTexte(), PDO::PARAM_STR);
		$req->bindValue(':pageNum', $article->getPageNum(), PDO::PARAM_INT);
        $req->execute();
	}

	/*
	Fonction qui supprime un Article de la BD en fonction de son numéro
	Paramètre :
		- $num : le numéro de l'Article à supprimer
	Retourne : rien
	*/
	public function deleteArticle($num){
		$sql="DELETE FROM article WHERE art_num=:num";
		$req=$this->db->prepare($sql);
		$req->bindValue(':num', $num, PDO::PARAM_INT);
		$req->execute();
	}

	public function modifierArticle($article)	{
		$sql="UPDATE article SET art_titre=:titre, art_date=:dateArt, art_texte=:texte, page_num=:pageNum WHERE art_num=:num";
		$req=$this->db->prepare($sql);
		$req->bindValue(':titre', $article->getTitre(), PDO::PARAM_STR);
		$req->bindValue(':dateArt', $article->getDate(), PDO::PARAM_STR);
		$req->bindValue(':texte', $article->getTexte(), PDO::PARAM_STR);
		$req->bindValue(':pageNum', $article->getPageNum(), PDO::PARAM_INT);
		$req->bindValue(':num', $article->getNum(), PDO::PARAM_INT);
		$req->execute();
	}

	/*
	Fonction qui permet de récupérer tous les Articles de la BD qui correspondent à une certaine page
	Paramètre :
		- $numPage : le numéro de la page qui doit contenir les Articles
	Retourne : un tableau qui contient les Articles récupérés par la requête
	*/
	public function getAllArticle($numPage){
		$tabObj=Array();
		$sql="SELECT * FROM article WHERE page_num =:numPage ORDER BY art_date DESC";
		$req=$this->db->prepare($sql);
        $req->bindValue('numPage', $numPage, PDO::PARAM_INT);
        $req->execute();
		while($ligne=$req->fetch(PDO::FETCH_OBJ)){
			$tabObj[]=new Article($ligne);
		}
		return $tabObj;
	}
}
?>
