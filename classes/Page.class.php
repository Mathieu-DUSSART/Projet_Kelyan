<?php
class Page{
    private $num;
    private $nom;
    private $hidden = 0;
    private $supprimable = 1;

    public function __construct($valeurs = array()){
        if(!empty($valeurs)){
            $this->affecte($valeurs);
        }
    }

    public function affecte($tab = array()){
		foreach($tab as $id => $valeurs){
			switch ($id){
				case 'page_num' : $this->setNum($valeurs);
					break;
				case 'page_nom' : $this->setNom($valeurs);
					break;
                case 'page_hidden' : $this->setHidden($valeurs);
					break;
                case 'page_supprimable' : $this->setSupprimable($valeurs);
					break;
			}
		}
	}

    public function setNum($num){
		$this->num=$num;
	}

    public function setNom($nom){
        $this->nom=$nom;
    }

    public function setHidden($hidden){
        $this->hidden=$hidden;
    }

    public function setSupprimable($supprimable){
        $this->supprimable=$supprimable;
    }




	public function getNum(){
		return $this->num;
	}

    public function getNom(){
        return $this->nom;
    }

    public function getHidden(){
		return $this->hidden;
	}

    public function getSupprimable(){
        return $this->supprimable;
    }
}
?>
