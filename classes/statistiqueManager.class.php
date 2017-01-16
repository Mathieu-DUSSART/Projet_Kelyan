<?php
public class statistiqueManager{
  private $db;

  public function __construct($db){
    $this->db=$db;
  }

  public function addStatistique($val){
    $sql="INSERT INTO statistique VALUES(:num, :pointCollecte)";
  }
}
 ?>
