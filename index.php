<!DOCTYPE html>
<html>
    <?php
    require_once("include/config.inc.php");
    require_once("include/autoLoad.inc.php");
    require_once("include/pages/function.inc.php");
    $pdo=new Mypdo();
    $managerPage=new PageManager($pdo);
    $managerArticle=new ArticleManager($pdo);
    $managerImage=new ImageManager($pdo);
    $managerEvenement=new EvenementManager($pdo);
    ?>
    <head>
        <title>Association Kelyan</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="js/function.js"></script>
    </head>
    <body>
        <header>
            <?php
            require_once("include/header.inc.php");
            ?>
        </header>
        <nav>
            <?php
            require_once("include/nav.inc.php");
            ?>
        </nav>

        <div id="corps">
            <?php
            require_once("include/contenu.inc.php");
            ?>
        </div>

        <footer>
            <?php
            require_once("include/footer.inc.php");
            ?>
        </footer>
    </body>
</html>
