<?php
class Contenu{
    private $group_num;
    private $img_num;

    public function __construct($valeurs = array()){
        if(!empty($valeurs)){
            $this->affecte($valeurs);
        }
    }

    public function affecte($tab = array()){
		foreach($tab as $id => $valeurs){
			switch ($id){
				case 'group_num' : $this->setGroupNum($valeurs);
					break;
				case 'img_num' : $this->setImgNum($valeurs);
					break;
			}
		}
	}

    public function setGroupNum($num){
		$this->group_num=$num;
	}

    public function setImgNum($num){
        $this->img_num=$num;
    }



	public function getGroupNum(){
		return $this->group_num;
	}

    public function getImgNum(){
        return $this->img_num;
    }

}
?>
