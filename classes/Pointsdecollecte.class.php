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
                case 'point_num' : $this->setPointNum($valeurs);
                    break;
                case 'point_lieu' : $this->setPointLieu($valeurs);
                    break;
                case 'vil_num' : $this->setPointVille($valeurs);
                    break;
                case 'point_visibilite' : $this->setPointVisibilite($valeurs);
                    break;
            }
        }
    }

    public function setPointNum($num){
        $this->num = $num;
    }

    public function setPointLieu($lieu){
        $this->lieu = $lieu;
    }

    public function setPointVille($ville){
        $this->ville = $ville;
    }

    public function setPointVisibilite($visibilite){
        $this->visibilite = $visibilite;
    }


    public function getPointNum(){
        return $this->num;
    }

    public function getPointLieu(){
        return $this->lieu;
    }

    public function getPointVille(){
        return $this->ville;
    }

    public function getPointVisibilite(){
        return $this->visibilite;
    }
}
?>
