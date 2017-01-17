<?php
 /************************************************************
  * Definition des constantes / tableaux et variables
  *************************************************************/


 // Tableaux de donnees
 $tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
 $infosImg = array();

 // Variables
 $extension = '';
 $message = '';
 $nomImage = '';

 /************************************************************
  * Script d'upload
  *************************************************************/
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
                         $tabImg["img_src"]="/Projet_Kelyan/image/galerie/";
                         $tabImg["img_nom"]=$nomImage;
                         $tabImg["img_description"]=null;
                         $tabImg["img_lien"]=null;
                         $image=new Image($tabImg);
                         $managerImage->add($image);
                         $message = 'Upload réussi !';

                         header('Location: index.php?page=4');
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


$infosVideo = array();
$tabExtVideo = array('mp4','avi','mkv');     // Extensions video autorisees

// Variables
$extension = '';
$message = '';
$nomVideo = '';

/************************************************************
 * Script d'upload Video
 *************************************************************/
if(!empty($_POST)){
   // On verifie si le champ est rempli
   if( !empty($_FILES['fichierVideo']['name']) ){
       // Recuperation de l'extension du fichier
       $extension  = pathinfo($_FILES['fichierVideo']['name'], PATHINFO_EXTENSION);
       // On verifie l'extension du fichier
       if(in_array(strtolower($extension),$tabExtVideo)){
           // On recupere les dimensions du fichier
           // $infosVideo = getimagesize($_FILES['fichierVideo']['tmp_name']);
           // On verifie le type de l'image
         //  if($infosImg[2] >= 1 && $infosImg[2] <= 14){
               // On verifie les dimensions et taille de l'image
           //  if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE)){//
                 // Parcours du tableau d'erreurs
                 if(isset($_FILES['fichierVideo']['error']) && UPLOAD_ERR_OK === $_FILES['fichierVideo']['error']){
                   // On renomme le fichier
                   $nomVideo = md5(uniqid()) .'.'. $extension;
                    // Si c'est OK, on teste l'upload
                    if(move_uploaded_file($_FILES['fichierVideo']['tmp_name'], TARGET.$nomVideo))
                    {
                        $tabVideo=Array();
                        $tabVideo["video_src"]="/Projet_Kelyan/video/";
                        $tabVideo["video_nom"]=$nomVideo;
                        $tabVideo["video_description"]=null;
                        $video=new Video($tabVideo);
                        $managerVideo->add($video);
                        $message = 'Upload réussi !';

                        header('Location: index.php?page=4');
                        exit;
                    }else{
                      // Sinon on affiche une erreur systeme
                      $message = 'Problème lors de l\'upload !';
                    }
                  }else{
                    $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
                  }
                //}else{
                  // Sinon erreur sur les dimensions et taille de l'image
                  //$message = 'Erreur dans les dimensions de l\'image !';
                //}
              //}else{
                // Sinon erreur sur le type de l'image
             //   $message = 'Le fichier à uploader n\'est pas une image !';
             //  }
           }else{
           // Sinon on affiche une erreur pour l'extension
           $message = 'L\'extension du fichier est incorrecte !';
           }
   }else{
    // Sinon on affiche une erreur pour le champ vide
    $message = 'Veuillez remplir le formulaire svp !';
   }
}
?>
<?php
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
    header('Location: index.php?page=4');
    exit;
}

if( !empty($message) ){
    echo '<p>',"\n";
    echo "\t\t<strong>", htmlspecialchars($message) ,"</strong>\n";
    echo "\t</p>\n\n";
}?>

<h1 class="titreOrange">Galerie</h1>

<link rel="stylesheet" type="text/css" href="fancyBox\fancyBox-master\source\jquery.fancybox.css?v=2.1.5" media="screen" />
<h2>Images :</h2>
<?php
//Affiche toutes les images de la page Galerie
foreach ($managerImage->getAllImage("/Projet_Kelyan/image/galerie/") as $image) {?>
    <div class="img">
        <?php
      echo "<a class=\"fancybox\" href=\"" . $image->getSrc() . $image->getNom() . "\" data-fancybox-group=\"gallery\"><img src=\"" . $image->getSrc() . $image->getNom() . "\"alt=\"\" width=\"400\" height=\"150\"></a>";
        if(isset($_SESSION["login"])){?>
            <div class="supprimerImage">
                <form method="POST" action="#">
                    <input name="supprimerImage" type="submit" value="X">
                    <input name="numImageASupprimer" type="hidden" value="<?php echo $image->getNum(); ?>">
                </form>
            </div>
        <?php
        }?>
    </div>
<?php
}

if(isset($_SESSION["login"])){?>
    <div id="ajouterImage">
        <form enctype="multipart/form-data" action="#" method="post">
            <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Envoyer le fichier</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
            <input name="fichier" type="file" id="fichier_a_uploader" />
            <input class="bouton" type="submit" name="submit" value="Uploader" />
        </form>
    </div>

 <?php
 }?>
<!-------------------------------------------------------------------Video------------------------------------------------------------------------------------------------>
 <h2>Vidéo :</h2>
 <?php
 foreach($managerVideo->getAllVideo("/Projet_Kelyan/video/") as $video){?>
   <div class="vid">
     <?php
     echo "<video controls src=\"" . $video->getSrc() . $video->getNom() . "\">" . $video->getDescription() . "</video>";
     if(isset($_SESSION["login"])){?>
         <div class="supprimerVideo">
             <form method="POST" action="#">
                 <input name="supprimerVideo" type="submit" value="X">
                 <input name="numVideoASupprimer" type="hidden" value="<?php echo $video->getNum(); ?>">
             </form>
         </div>
     <?php
     }?>
   </div>
 <?php
 }
 if(isset($_SESSION["login"])){?>
     <div id="ajouterVideo">
         <form enctype="multipart/form-data" action="#" method="post">
             <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Envoyer le fichier</label>
             <input type="hidden" name="MAX_FILE_SIZE_VIDEO" value="<?php echo MAX_SIZE; ?>" />
             <input name="fichierVideo" type="file" id="fichier_a_uploader" />
             <input class="bouton" type="submit" name="submit" value="Uploader" />
         </form>
     </div>
 <?php
 }
?>
