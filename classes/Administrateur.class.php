<?php
class Administrateur{
    private $num;
    private $login;
    private $password;

    public function __construct($valeurs = array()){
        if(!empty($valeurs)){
            $this->affecte($valeurs);
        }
    }

    public function affecte($tab = array()){
        foreach($tab as $id => $valeurs){
            switch ($id){
                case 'admin_num' : $this->setNum($valeurs);
                    break;
                case 'admin_login' : $this->setLogin($valeurs);
                    break;
                case 'admin_password' : $this->setPassword($valeurs);
                    break;
            }
        }
    }

    public function setNum($num){
        $this->num = $num;
    }

    public function setLogin($login){
        $this->login = $login;
    }

    public function setPassword($password){
        $this->password = $password;
    }


    public function getNum(){
        return $this->num;
    }

    public function getLogin(){
        return $this->login;
    }

    public function getPassword(){
        return $this->password;
    }
}
?>
