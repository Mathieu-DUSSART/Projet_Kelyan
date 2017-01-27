<?php
if (!empty($_GET["page"])){
    $numPage=$_GET["page"];}
else{
    $numPage=1;
}?>

<ul>
    <?php
    foreach($managerPage->getAllPage() as $page){
        if($numPage==$page->getNum()){
            echo "<li><a href=\"index.php?page=" . $page->getNum() . "\" class=\"active\"><p class=\"page" . $page->getNum()%5 . "\">" . $page->getNom() . "</p></a>";
        }else{
            if($page->getNom()=="Statistique"){
                if(isset($_SESSION["login"])){
                    echo "<li><a href=\"index.php?page=" . $page->getNum() . "\"><p class=\"page" . $page->getNum()%5 . "\">" . $page->getNom() . "</p></a>";
                }
            }else{
                echo "<li><a href=\"index.php?page=" . $page->getNum() . "\"><p class=\"page" . $page->getNum()%5 . "\">" . $page->getNom() . "</p></a>";
            }
        }
    }
    if($page->getNom()!="Statistique"){
        if(!isset($_SESSION["login"])){
            echo "</li>";
        }
    }?>
</ul>
