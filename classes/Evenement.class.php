<?php
class Evenement{
    private $num;
    private $titre;
    private $date;
    private $heure;
    private $texte;
    private $ville;

    public function __construct($valeurs = array()){
        if(!empty($valeurs)){
            $this->affecte($valeurs);
        }
    }

    public function affecte($tab = array()){
		foreach($tab as $id => $valeurs){
			switch ($id){
				case 'event_num' : $this->setNum($valeurs);
					break;
				case 'event_titre' : $this->setTitre($valeurs);
					break;
                case 'event_date' : $this->setDate($valeurs);
					break;
                case 'event_heure' : $this->setHeure($valeurs);
                    break;
                case 'event_texte' : $this->setTexte($valeurs);
					break;
                case 'event_ville' : $this->setVille($valeurs);
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

    public function setHeure($heure){
        $this->heure=$heure;
    }

    public function setTexte($texte){
        $this->texte=$texte;
    }

    public function setVille($ville){
        $this->ville=$ville;
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

    public function getHeure(){
		return $this->heure;
	}

    public function getTexte(){
        return $this->texte;
    }

    public function getVille(){
        return $this->ville;
    }
}
?>
