<!DOCTYPE html>
<html>
    <?php
    session_start();
    require_once("include/config.inc.php");
    require_once("include/autoLoad.inc.php");
    require_once("include/pages/function.inc.php");
    $pdo=new Mypdo();
    $managerPage = new PageManager($pdo);
    $managerArticle = new ArticleManager($pdo);
    $managerImage = new ImageManager($pdo);
    $managerEvenement = new EvenementManager($pdo);
    $managerAdministrateur = new AdministrateurManager($pdo);
    $managerPointsDeCollecte = new Pointsdecollectemanager($pdo);
    $managerVille = new VilleManager($pdo);
    ?>
    <head>
        <title>Association Kelyan</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="js/function.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
        <script type="text/javascript" src="D:\application\fancbox\fancyBox-master\source\jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript" src="D:\application\fancbox\fancyBox-master\lib\jquery.mousewheel-3.0.4.pack.js"></script>
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
