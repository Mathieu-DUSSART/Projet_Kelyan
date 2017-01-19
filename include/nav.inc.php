<?php
if (!empty($_GET["page"])){
    $numPage=$_GET["page"];}
else{
    $numPage=1;
}


//Permet d'ajouter la nouvelle page dans la BD et de créer
//le fichier correspondant dans le dossier "include/pages"
if(isset($_POST["nomPage"])){
    if($managerPage->existePage($_POST["nomPage"])){
        echo "La page existe déjà";
    }else{
        $tab= Array();
        $tab["page_nom"]=$_POST["nomPage"];
        $page=new Page($tab);
        $managerPage->add($page);
        $manip = fopen("include/pages/" .  str_replace(' ','',strtolower(strRemoveAccent($_POST["nomPage"]))) . ".inc.php", "w+");
        if($manip==false)
        die("La création du fichier a échoué");
        header('Location: index.php?page=' . $_GET["page"]);
        exit;
    }

}

//Permet de modifier une page
if(isset($_POST["nomPageModifie"])){
    $tab= Array();
    $tab["page_num"]=$_SESSION["numPageAModifier"];
    $tab["page_nom"]=$_POST["nomPageModifie"];
    $page=new Page($tab);
    $managerPage->modifierPage($page);
    rename("include/pages/" . str_replace(' ','',strtolower(strRemoveAccent($_SESSION["nomPageAvantModif"]))) . ".inc.php", "include/pages/" . str_replace(' ','',strtolower(strRemoveAccent($page->getNom()))) . ".inc.php");
    header('Location: index.php?page=' . $_GET["page"]);
    exit;
}

//Permet de supprimer une page
if(isset($_POST["supprimerPage"])){
    $page = $managerPage->getPage($_POST["numPageASupprimer"]);
    $managerPage->deletePage($page->getNum());
    $fichier = "include/pages/" .  str_replace(' ','',strtolower(strRemoveAccent($page->getNom()))) . ".inc.php";
    //Supprime le fichier s'il existe
    if(file_exists ( $fichier)){
        unlink( $fichier );
    }
    header('Location: index.php?page=' . $_GET["page"]);
    exit;
}
?>

<ul>
    <?php
    foreach($managerPage->getAllPage() as $page){
        if(isset($_POST["modifierPage"]) && $_POST['numPageAModifier'] == $page->getNum()){
            $_SESSION["numPageAModifier"]=$page->getNum();
            $_SESSION["nomPageAvantModif"]=$page->getNom();
            ?>
            <li>
                <form action="#" method="POST">
                    <input name="nomPageModifie" type="text" value=" <?php echo $page->getNom();?>" required><br>
                    <input type="submit" value="Valider">
                </form>
            </li>
        <?php
        }else{
            if($numPage==$page->getNum()){
                echo "<li><a href=\"index.php?page=" . $page->getNum() . "\" class=\"active\"><p class=\"page" . $page->getNum()%5 . "\">" . $page->getNom() . "</p></a>";
            }else{
                echo "<li><a href=\"index.php?page=" . $page->getNum() . "\"><p class=\"page" . $page->getNum()%5 . "\">" . $page->getNom() . "</p></a>";
            }
        }
        if(isset($_SESSION["login"]) && $managerPage->estSupprimable($page->getNum())){
            if(!isset($_POST["modifierPage"]) || (isset($_POST["modifierPage"]) && $_POST["numPageAModifier"]!=$page->getNum())){?>
                <div class="divSupprimerPage">
                    <form class="supprimerArticle" method="POST" action="#">
                        <input name="supprimerPage" type="submit" value="X">
                        <input name="numPageASupprimer" type="hidden" value="<?php echo $page->getNum(); ?>">
                    </form>
                    <form class="modifierArticle" method="POST" action="#">
                        <input name="modifierPage" type="submit" value="M">
                        <input name="numPageAModifier" type="hidden" value="<?php echo $page->getNum(); ?>">
                    </form>
                </div>
            <?php
            }
        }?>

        </li>
    <?php
    }?>
    <li id="menu">v
        <div id="menuDeroulant">

        </div>
    </li>

    <?php
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
