<?php
class AdministrateurManager{
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function checkLoginPassword($login, $password){
        $sql = "SELECT admin_num FROM administrateur WHERE admin_login = :login AND admin_password = :password";
        $req = $this->db->prepare($sql);
        $req->bindValue(':login', $login, PDO::PARAM_STR);
        $req->bindValue(':password', $password, PDO::PARAM_STR);
        $req->execute();
        $resu = $req->fetch(PDO::FETCH_OBJ);

        return (isset($resu->admin_num));
    }

}
?>
