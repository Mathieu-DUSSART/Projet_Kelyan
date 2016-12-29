<?php
class Article{
    private $num;
    private $titre;
    private $date;
    private $texte;
    private $pageNum;

    public function __construct($valeurs = array()){
        if(!empty($valeurs)){
            $this->affecte($valeurs);
        }
    }

    public function affecte($tab = array()){
		foreach($tab as $id => $valeurs){
			switch ($id){
				case 'art_num' : $this->setNum($valeurs);
					break;
				case 'art_titre' : $this->setTitre($valeurs);
					break;
                case 'art_date' : $this->setDate($valeurs);
					break;
                case 'art_texte' : $this->setTexte($valeurs);
					break;
                case 'page_num' : $this->setPageNum($valeurs);
					break;
			}
		}
	}

    public function setNum($num){
        $this->num=$num;
    }

    public function setTitre($titre){
        $this->titre=$titre;
    }

    public function setDate($date){
        $this->date=$date;
    }

    public function setTexte($texte){
        $this->texte=$texte;
    }

    public function setPageNum($pageNum){
        $this->pageNum=$pageNum;
    }

    //-------------

    public function getNum(){
		return $this->num;
	}

    public function getTitre(){
        return $this->titre;
    }

    public function getDate(){
		return $this->date;
	}

    public function getTexte(){
        return $this->texte;
    }

    public function getPageNum(){
		return $this->pageNum;
	}
}
?>
