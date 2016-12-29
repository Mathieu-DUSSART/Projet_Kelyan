<?php
class Page{
    private $num;
    private $nom;
    
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
			}
		}
	}
    
    public function setNum($num){
		$this->num=$num;
	}

    public function setNom($nom){
        $this->nom=$nom;
    }



	public function getNum(){
		return $this->num;
	}

    public function getNom(){
        return $this->nom;
    }
}
?>