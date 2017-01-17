<!DOCTYPE html>
<html>
    <?php
    session_start();
    require_once("include/config.inc.php");
    require_once("include/autoLoad.inc.php");
    require_once("include/function.inc.php");
    $pdo=new Mypdo();
    $managerPage = new PageManager($pdo);
    $managerArticle = new ArticleManager($pdo);
    $managerImage = new ImageManager($pdo);
    $managerEvenement = new EvenementManager($pdo);
    $managerAdministrateur = new AdministrateurManager($pdo);
    $managerPointsDeCollecte = new PointsDeCollecteManager($pdo);
    $managerVille = new VilleManager($pdo);
    $managerStatistique = new StatistiqueManager($pdo);
    $managerVideo = new VideoManager($pdo);
    ?>
    <head>
        <title>Association Kelyan</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="js/function.js"></script>
        <!-- lib jquery -->
        <script type="text/javascript" src="fancyBox\fancyBox-master\lib\jquery-1.10.2.min.js"></script>

          <!-- Add mousewheel plugin (this is optional) -->
          <script type="text/javascript" src="fancyBox\fancyBox-master\lib\jquery.mousewheel.pack.js?v=3.1.3"></script>

          <!-- Add fancyBox main JS and CSS files -->
          <script type="text/javascript" src="fancyBox\fancyBox-master\source\jquery.fancybox.pack.js?v=2.1.5"></script>
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
