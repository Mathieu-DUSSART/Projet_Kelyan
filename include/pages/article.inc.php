<?php
//Récupère la date d'aujourd'hui au format SQL (2016-04-19 14:59:59)
$date = date('Y-m-d H:i:s');
//Ajoute un article
if(isset($_POST["titre"])){
    $tab=array();
    $tab["art_titre"]=$_POST["titre"];
    $tab["art_date"]=$date;
    $tab["art_texte"]=$_POST["texte"];
    $tab["page_num"]=$_GET["page"];
    $article=new Article($tab);
    $managerArticle->add($article);
    header('Location: index.php?page=2');
    exit;
}

//Modifie un article
if(isset($_POST["titreModifie"])){
    $tab=array();
    $tab["art_num"]=$_SESSION["numArticleAModifier"];
    $tab["art_titre"]=$_POST["titreModifie"];
    $tab["art_texte"]=$_POST["texteModifie"];
    $article=new Article($tab);
    $managerArticle->modifierArticle($article);
    header('Location: index.php?page=2');
    exit;
}

//Supprime un article
if(isset($_POST["numArticleASupprimer"])){
    $managerArticle->deleteArticle($_POST["numArticleASupprimer"]);
    header('Location: index.php?page=2');
    exit;
}
?>

<h1 class="titreRouge">Article</h1>

<?php
//Affiche les articles de la page Article
foreach ($managerArticle->getAllArticle(2) as $article) {
    //Récupère la date de l'article au format 23/09/2016
    $date = date_format(date_create($article->getDate()), 'd/m/Y H:i');?>

        <?php
        if(isset($_POST["modifierArticle"]) && $_POST["numArticleAModifier"]==$article->getNum()){
            $_SESSION["numArticleAModifier"]=$article->getNum();
            ?>
            <div id="formulaireAjoutArticle">
                <form class="modifier" method="POST" action="#">
                    <label>Titre de l'article:</label>
                    <input  type="text" name="titreModifie" value="<?php echo $article->getTitre(); ?>" required>
                    <br>
                    <label>Texte:</label>
                    <textarea name="texteModifie" class ="texteArea" rows="8" required><?php echo $article->getTexte(); ?></textarea>
                    <br>
                    <input class="boutonModifierFinal" type="button" value="Modifier l'article">
                </form>
            </div>
        <?php
        }else{?>
            <div class="divArticle">
                <article>
                    <?php
                    echo "<h1>" . $article->getTitre() . "</h1>";
                    echo "<p class=\"dateArticle\">" . $date . "</p>";
                    echo $article->getTexte();
                    ?>
                </article>
                <?php
                if(isset($_SESSION["login"])){
                    if(!isset($_POST["modifierArticle"]) || (isset($_POST["modifierArticle"]) && $_POST["numArticleAModifier"]!=$article->getNum())){?>
                        <div class="voletGestionArticle">
                          <form class="supprimer" method="POST" action="#">
                              <input name="supprimerArticle" class="boutonSupprimer input_btn1" type="button" value="Supprimer">
                              <input class="num" name="numArticleASupprimer" type="hidden" value="<?php echo $article->getNum(); ?>">
                          </form>
                          <form class="modifierArticle" method="POST" action="#">
                              <input name="modifierArticle" class="boutonModifier input_btn2" type="submit" value="Modifier" >
                              <input class="numModif" name="numArticleAModifier" type="hidden" value="<?php echo $article->getNum(); ?>">
                          </form>
                        </div>
                    <?php
                    }
                }
                ?>
            </div>
        <?php
        }
}

//Formulaire d'ajout d'article
if(isset($_SESSION["login"])){?>
    <div id="formulaireAjoutArticle">
        <input type="button" id="boutonPlusFormulaireAjout" value="+">
        <form method="POST" action="#" id="formulaireArticle" novalidate>
            <label>Titre de l'article:</label>
            <input  type="text" name="titre" placeholder="Titre de l'article..." required>
            <br>
            <label>Texte:</label>
            <textarea name="texte" class ="texteArea" placeholder="Ecrivez votre article ici..." rows="8" required></textarea>
            <br>
            <input class="bouton" type="submit" value="Ajouter l'article">
        </form>
    </div>
<?php
}?>
