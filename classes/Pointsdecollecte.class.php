<?php
class Pointsdecollecte{
    private $num;
    private $lieu;
    private $ville;
    private $visibilite;

    public function __construct($valeurs = array()){
        if(!empty($valeurs)){
            $this->affecte($valeurs);
        }
    }

    public function affecte($tab = array()){
        foreach($tab as $id => $valeurs){
            switch ($id){
                case 'point_num' : $this->setNum($valeurs);
                    break;
                case 'point_lieu' : $this->setLieu($valeurs);
                    break;
                case 'point_ville' : $this->setVille($valeurs);
                    break;
                case 'point_visibilite' : $this->setVisibilite($valeurs);
                    break;
            }
        }
    }

    public function setNum($num){
        $this->num = $num;
    }

    public function setLieu($lieu){
        $this->lieu = $lieu;
    }

    public function setVille($ville){
        $this->ville = $ville;
    }

    public function setVisibilite($visibilite){
        $this->visibilite = $visibilite;
    }


    public function getNum(){
        return $this->num;
    }

    public function getLieu(){
        return $this->lieu;
    }

    public function getVille(){
        return $this->ville;
    }

    public function getVisibilite(){
        return $this->visibilite;
    }
}
?>
