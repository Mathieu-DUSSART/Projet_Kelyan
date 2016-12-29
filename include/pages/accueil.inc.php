<h1 class="titreJaune">Présentation de l'association</h1>

<?php
//Affiche les articles de la page d'accueil
foreach ($managerArticle->getAllArticle(1) as $article) {?>
    <article>
        <?php
        echo "<h1><div class=\"icon" . $article->getNum() ."\"></div>" . $article->getTitre() . "</h1>\n";
        echo "<p>" . $article->getTexte() . "</p>\n";
        ?>
    </article>
<?php
}
?>
