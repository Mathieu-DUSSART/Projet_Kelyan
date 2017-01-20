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
header('Location: index.php?page=1');
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
header('Location: index.php?page=1');
exit;
}

//Supprime un article
if(isset($_POST["numArticleASupprimer"])){
$managerArticle->deleteArticle($_POST["numArticleASupprimer"]);
header('Location: index.php?page=1');
exit;
}
?>

<h1 class="titreJaune">Présentation de l'association</h1>

<?php
//Affiche les articles de la page d'accueil
foreach ($managerArticle->getAllArticle(1) as $article) {

  if(isset($_POST["modifierArticle"]) && $_POST["numArticleAModifier"]==$article->getNum()){
      $_SESSION["numArticleAModifier"]=$article->getNum();
      ?>
      <div id="formulaireAjoutArticle">
          <form class="modifier" method="POST" action="#">
              <label>Titre de l'article:</label>
              <input  type="text" name="titreModifie" value="<?php echo $article->getTitre(); ?>" required>
              <br>
              <label>Texte:</label>
              <textarea name="texteModifie" rows="8" required><?php echo $article->getTexte(); ?></textarea>
              <br>
              <input class="boutonModifier" type="submit" value="Modifier l'article">
          </form>
      </div>
  <?php
  }else{?>
    <article>
        <?php
        echo "<h1><span class=\"icon" . $article->getNum() ."\"></span>" . $article->getTitre() . "</h1>\n";
        echo "<p>" . $article->getTexte() . "</p>\n";
        ?>
    </article>
<?php
}


if(isset($_SESSION["login"])){
    if(!isset($_POST["modifierArticle"]) || (isset($_POST["modifierArticle"]) && $_POST["numArticleAModifier"]!=$article->getNum())){?>
        <div class="voletGestionArticle">
            <form class="supprimerArticle" method="POST" action="#">
                <input name="supprimerArticle" class="boutonSupprimer" type="button" value="X">
                <input class="num" name="numArticleASupprimer" type="hidden" value="<?php echo $article->getNum(); ?>">
            </form>
            <form class="modifierArticle" method="POST" action="#">
                <input name="modifierArticle" class="boutonModifier" type="submit" value="M">
                <input name="numArticleAModifier" type="hidden" value="<?php echo $article->getNum(); ?>">
            </form>
        </div>
    <?php
    }
}
}

if(isset($_SESSION["login"])){?>
<div id="formulaireAjoutArticle">
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
}?>
