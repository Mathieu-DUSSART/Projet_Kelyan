
<!-- Add jQuery library -->
	<script type="text/javascript" src="fancyBox-master\lib\jquery-1.10.2.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="fancyBox-master\lib\jquery.mousewheel.pack.js?v=3.1.3"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="fancyBox-master\source\jquery.fancybox.pack.js?v=2.1.5"></script>

  <?php
  // Constantes
  define('TARGET', 'image/reseaux_sociaux/');    // Repertoire cible
  define('MAX_SIZE', 10000000);    // Taille max en octets du fichier
  define('WIDTH_MAX', 50000);    // Largeur max de l'image en pixels
  define('HEIGHT_MAX', 50000);    // Hauteur max de l'image en pixels

  // Tableaux de donnees
  $tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
  $infosImg = array();

  // Variables
  $extension = '';
  $message = '';
  $nomImage = '';
  if(!empty($_POST)){
      // On verifie si le champ est rempli
      if( !empty($_FILES['fichier']['name']) ){
          // Recuperation de l'extension du fichier
          $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
          // On verifie l'extension du fichier
          if(in_array(strtolower($extension),$tabExt)){
              // On recupere les dimensions du fichier
              $infosImg = getimagesize($_FILES['fichier']['tmp_name']);
              // On verifie le type de l'image
              if($infosImg[2] >= 1 && $infosImg[2] <= 14){
                  // On verifie les dimensions et taille de l'image
                  if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE)){
                    // Parcours du tableau d'erreurs
                    if(isset($_FILES['fichier']['error']) && UPLOAD_ERR_OK === $_FILES['fichier']['error']){
                      // On renomme le fichier
                      $nomImage = md5(uniqid()) .'.'. $extension;
                       // Si c'est OK, on teste l'upload
                       if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomImage))
                       {
                           $tabImg=Array();
                           $tabImg["img_src"]="/Projet_Kelyan/image/reseaux_sociaux/";
                           $tabImg["img_nom"]=$nomImage;
                           $tabImg["img_description"]=null;
                           $tabImg["img_lien"]=$_POST["lien"];
                           $image=new Image($tabImg);
                           $managerImage->add($image);
                           $message = 'Upload réussi !';

                           header('Location: index.php?page=' . $_GET["page"]);
                           exit;
                       }else{
                         // Sinon on affiche une erreur systeme
                         $message = 'Problème lors de l\'upload !';
                       }
                     }else{
                       $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
                     }
                   }else{
                     // Sinon erreur sur les dimensions et taille de l'image
                     $message = 'Erreur dans les dimensions de l\'image !';
                   }
                  }else{
                   // Sinon erreur sur le type de l'image
                   $message = 'Le fichier à uploader n\'est pas une image !';
                  }
              }else{
              // Sinon on affiche une erreur pour l'extension
              $message = 'L\'extension du fichier est incorrecte !';
              }
      }else{
       // Sinon on affiche une erreur pour le champ vide
       $message = 'Veuillez remplir le formulaire svp !';
      }
  }
  //Supprime une image
  if(isset($_POST["supprimerImage"])){
     $image=$managerImage->getImage($_POST["numImageASupprimer"]);
     $managerImage->deleteImage($image->getNum());
     //Fichier à supprimer
     $fichier = TARGET . $image->getNom();
     //Si le fichier existe, on le supprime
     if(file_exists($fichier)){
      unlink($fichier);
     }
     header('Location: index.php?page=' . $_GET["page"]);
     exit;
  }
  foreach ($managerImage->getAllImage("/Projet_Kelyan/image/reseaux_sociaux/") as $image) { ?>
    <?php  echo "<a href=\"" . $image->getLien() . "\"><img id=\"logoFB\" src=\"" . $image->getSrc() . $image->getNom() . "\"alt=\"\"></a>";
      if(isset($_SESSION["login"])){ ?>
          <div class="supprimerImage">
              <form method="POST" action="#">
                  <input name="supprimerImage" type="submit" value="X">
                  <input name="numImageASupprimer" type="hidden" value="<?php echo $image->getNum(); ?>">
              </form>
          </div>
      <?php
    } ?>
    <?php }

  /*  if(isset($_SESSION["login"])){?>
      <input id="boutonAjoutReseauSocial" type="button" value="">
      <div id="ajouterLogo">
        <form enctype="multipart/form-data" id="ajouterArticle" method="POST" action="#">
          <label>Image du reseau social :</label>
          <input name="fichier" type="file" id="fichier_a_uploader" />
          <label>Lien vers le reseau social : </label>
          <input type="url" name="lien">
          <input type="submit" value="Valider">
        </form>
      </div>
    <?php } */?>

  <img id="logo" src="image/logo.jpeg" alt="">
  <h1>Association Kélyan</h1>
