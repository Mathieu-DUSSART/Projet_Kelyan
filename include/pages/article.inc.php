<h1 class="titreRouge">Article</h1>

<?php
//Affiche les articles de la page Article
foreach ($managerArticle->getAllArticle(2) as $article) {
    //Récupère la date de l'article au format 23/09/2016
    $date = date_format(date_create($article->getDate()), 'd/m/Y H:i');?>

        <?php
        if(isset($_POST["modifierArticle"]) && $_POST["numArticleAModifier"]==$article->getNum()){?>
            <div id="ajouterArticle">
                <form method="POST" action="#">
                    <label>Titre de l'article:</label>
                    <input  type="text" name="titre" value="<?php echo $article->getTitre(); ?>" required>
                    <br>
                    <label>Texte:</label>
                    <textarea name="texte" rows="8" required><?php echo $article->getTexte(); ?></textarea>
                    <br>
                    <input class="bouton" type="submit" value="Modifier l'article">
                </form>
            </div>
        <?php
        }else{?>
            <article>
                <?php
                echo "<h1>" . $article->getTitre() . "</h1>";
                echo "<p class=\"dateArticle\">" . $date . "</h1>";
                echo "<p>" . $article->getTexte() . "</p>";
                ?>
            </article>
        <?php
        }
        ?>



    <?php
    if(isset($_SESSION["login"])){
        if(!isset($_POST["modifierArticle"]) || (isset($_POST["modifierArticle"]) && $_POST["numArticleAModifier"]!=$article->getNum())){?>
            <div class="voletGestionArticle">
                <form class="supprimerArticle" method="POST" action="#">
                    <input name="supprimerArticle" type="submit" value="X">
                    <input name="numArticleASupprimer" type="hidden" value="<?php echo $article->getNum(); ?>">
                </form>
                <form class="modifierArticle" method="POST" action="#">
                    <input name="modifierArticle" type="submit" value="M">
                    <input name="numArticleAModifier" type="hidden" value="<?php echo $article->getNum(); ?>">
                </form>
            </div>
        <?php
        }
    }
}

if(isset($_SESSION["login"])){?>
    <div id="ajouterArticle">
        <form method="POST" action="#">
            <label>Titre de l'article:</label>
            <input  type="text" name="titre" placeholder="Titre de l'article..." required>
            <br>
            <label>Texte:</label>
            <textarea name="texte" placeholder="Ecrivez votre article ici..." rows="8" required></textarea>
            <br>
            <input class="bouton" type="submit" value="Ajouter l'article">
        </form>
    </div>
<?php
}


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
//Supprime un article
if(isset($_POST["supprimerArticle"])){
    $managerArticle->deleteArticle($_POST["numArticleASupprimer"]);
    header('Location: index.php?page=2');
    exit;
}
?>
