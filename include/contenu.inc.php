<?php
if (!empty($_GET["page"])){
    $pageNum=$_GET["page"];}
else{
    $pageNum=1;
}

$page=$managerPage->getPage($pageNum);
include_once('pages/' . str_replace(' ','',strtolower(strRemoveAccent($page->getNom()))) . ".inc.php");



/*switch ($pageNum) {
    case 1:
        include_once('pages/accueil.inc.php');
        break;
    case 2:
        include_once('pages/article.inc.php');
        break;
    case 3:
        include_once('pages/evenement.inc.php');
        break;
    case 4:
        include_once('pages/galerie.inc.php');
        break;
    case 5:
        include_once('pages/contact.inc.php');
        break;

    default : include_once('pages/accueil.inc.php');
}*/
?>
