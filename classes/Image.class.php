<?php
class Image{
    private $num;
    private $src;
    private $nom;
    private $description;
    private $lien;
    private $type;

    public function __construct($valeurs = array()){
        if(!empty($valeurs)){
            $this->affecte($valeurs);
        }
    }

    public function affecte($tab = array()){
		foreach($tab as $id => $valeurs){
			switch ($id){
				case 'img_num' : $this->setNum($valeurs);
					break;
				case 'img_src' : $this->setSrc($valeurs);
					break;
                case 'img_nom' : $this->setNom($valeurs);
					break;
                case 'img_description' : $this->setDescription($valeurs);
					break;
                case 'img_lien' : $this->setLien($valeurs);
					break;
                case 'img_type' : $this->setType($valeurs);
          break;
			}
		}
	}

    public function setNum($num){
        $this->num=$num;
    }

    public function setSrc($src){
        $this->src=$src;
    }

    public function setNom($nom){
        $this->nom=$nom;
    }

    public function setDescription($description){
        $this->description=$description;
    }

    public function setLien($lien){
        $this->lien=$lien;
    }

    public function setType($type){
        $this->type=$type;
    }

    //-------------

    public function getNum(){
		return $this->num;
	}

    public function getSrc(){
        return $this->src;
    }

    public function getNom(){
		return $this->nom;
	}

    public function getDescription(){
		return $this->description;
	}

    public function getLien(){
        return $this->lien;
    }

    public function getType(){
        return $this->type;
    }
}
?>
