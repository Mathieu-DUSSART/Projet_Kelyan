<?php
class Groupe{
    private $group_num;
    private $group_nom;

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
				          case 'group_nom' : $this->setGroupNom($valeurs);
					  break;
			      }
    		}
	  }

    public function setGroupNum($num){
		    $this->group_num=$num;
	  }

    public function setGroupNom($nom){
        $this->group_nom=$nom;
    }



	  public function getGroupNum(){
		    return $this->group_num;
	  }

    public function getGroupNom(){
        return $this->group_nom;
    }

}
?>
