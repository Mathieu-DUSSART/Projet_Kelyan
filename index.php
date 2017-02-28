<!DOCTYPE html>
<html lang="fr">
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
    $managerContenu = new ContenuManager($pdo);
    $managerGroup = new GroupeManager($pdo);
    $managerPersonne = new PersonneManager($pdo);
    ?>
    <head>
        <title>Association Kelyan</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" media="only screen and (max-width: 1000px)" href="css/style_responsive.css" type="text/css" />

        <meta name="viewport" content="width=device-width" />
        <!-- Import JQuery-->
        <script src="js/jquery-3.1.1.min.js"></script>

        <!-- Import JQueryUI-->
        <script src="js/JQueryUI/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="js/JQueryUI/jquery-ui.min.css">

        <script src='tinymce/js/tinymce/tinymce.min.js'></script>

        <script src="js/function.js"></script>

          <!-- Add mousewheel plugin (this is optional) -->
          <script type="text/javascript" src="fancyBox/fancyBox-master/lib/jquery.mousewheel.pack.js?v=3.1.3"></script>
          <link rel="stylesheet" type="text/css" href="fancyBox/fancyBox-master/source/jquery.fancybox.css?v=2.1.5" media="screen" />
          <!-- Add fancyBox main JS and CSS files -->
          <script type="text/javascript" src="fancyBox/fancyBox-master/source/jquery.fancybox.pack.js?v=2.1.5"></script>
    </head>
    <body>
        <header>
            <?php
            require_once("include/header.inc.php");
            ?>
        </header>
        <div id="barreNav">
            <input type="button" id="boutonMenu">
        </div>
        <nav class="cacherNav">
            <?php
            require_once("include/nav.inc.php");
            ?>
        </nav>

        <div id="corps">
            <?php
            require_once("include/contenu.inc.php");
            ?>

            <div id="dialog-confirm-suppr" title="Supprimer">
                <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Voulez-vous vraiment supprimer ?</p>
            </div>

            <div id="dialog-confirm-modif" title="Modification">
                <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Voulez-vous vraiment apporter ces modifications ?</p>
            </div>
        </div>

        <footer id="footer">
            <?php
            require_once("include/footer.inc.php");
            ?>
        </footer>
    </body>
</html>
