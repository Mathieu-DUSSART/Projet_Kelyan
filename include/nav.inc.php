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
            echo "<li><a href=\"index.php?page=" . $page->getNum() . "\"><p class=\"page" . $page->getNum()%5 . "\">" . $page->getNom() . "</p></a>";
        }
        if(isset($_SESSION["login"])){
            if($managerPage->estSupprimable($page->getNum())){?>
                <div class="divSupprimerPage">
                    <form class="supprimerArticle" method="POST" action="#">
                        <input name="supprimerPage" type="submit" value="X">
                        <input name="numPageASupprimer" type="hidden" value="<?php echo $page->getNum(); ?>">
                    </form>
                </div>
            <?php
            }
        }?>

        </li>
    <?php
    }
    if(isset($_SESSION["login"])){?>
        <li id="ongletAjoutPage"><input id="boutonAjoutPage" type="button" value="">
            <div id="divAjoutPage">
                <form action="#" method="POST">
                    <input name="nomPage" type="text" placeholder="Nom de la page..." required>
                    <input type="submit" value="Valider">
                </form>
            </div>
        </li>
    <?php
    } ?>
</ul>

<?php
//Permet d'ajouter la nouvelle page dans la BD et de créer
//le fichier correspondant dans le dossier "include/pages"
if(isset($_POST["nomPage"])){
    $tab= Array();
    $tab["page_nom"]=$_POST["nomPage"];
    $page=new Page($tab);
    $managerPage->add($page);
    $manip = fopen("include/pages/" .  strtolower(strRemoveAccent($_POST["nomPage"])) . ".inc.php", "w+");
    if($manip==false)
    die("La création du fichier a échoué");
}

//Permet de supprimer une page
if(isset($_POST["supprimerPage"])){
    $page = $managerPage->getPage($_POST["numPageASupprimer"]);
    $managerPage->deletePage($page->getNum());
    $fichier = "include/pages/" .  strtolower(strRemoveAccent($page->getNom())) . ".inc.php";
    //Supprime le fichier s'il existe
    if(file_exists ( $fichier)){
        unlink( $fichier );
    }
}
?>
