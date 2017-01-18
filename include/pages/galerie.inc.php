<?php
 /************************************************************
  * Definition des constantes / tableaux et variables
  *************************************************************/


 // Tableaux de donnees
 $tabExtImg = array('jpg','gif','png','jpeg');    // Extensions autorisees
 $tabExtVideo = array('mp4','avi','mkv','mpeg');
 $infosImg = array();

 // Variables
 $extension = '';
 $message = '';
 $nomImage = '';

 /************************************************************
  * Script d'upload
  *************************************************************/
if(isset($_POST["formAjoutImage"])){
    // On verifie si le champ est rempli
    if( !empty($_FILES['fichier']['name']) ){
        // Recuperation de l'extension du fichier
        $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
        // On verifie l'extension du fichier
        if(in_array(strtolower($extension),$tabExtImg)){
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
                     if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET_GALERIE.$nomImage))
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


    // On verifie si le champ est rempli
if(isset($_POST["formAjoutVideo"])){
          if( !empty($_FILES['fichierVideo']['name']) ){
        // Recuperation de l'extension du fichier
        $extension  = pathinfo($_FILES['fichierVideo']['name'], PATHINFO_EXTENSION);
        echo "Ext =" . $extension;
        // On verifie l'extension du fichier
        if(in_array(strtolower($extension),$tabExtVideo)){
                // On verifie les dimensions et taille de l'image
                if(filesize($_FILES['fichierVideo']['tmp_name']) <= MAX_SIZE){
                  // Parcours du tableau d'erreurs
                  if(isset($_FILES['fichierVideo']['error']) && UPLOAD_ERR_OK === $_FILES['fichierVideo']['error']){
                    // On renomme le fichier
                    $nomImage = md5(uniqid()) .'.'. $extension;
                    echo "Nom =" . $nomImage;
                     // Si c'est OK, on teste l'upload
                     if(move_uploaded_file($_FILES['fichierVideo']['tmp_name'], TARGET_VIDEO.$nomImage))
                     {
                         $tabVideo=Array();
                         $tabVideo["video_src"]="/Projet_Kelyan/video/";
                         $tabVideo["video_nom"]=$nomImage;
                         $image=new Video($tabVideo);
                         $managerVideo->add($image);
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
    $fichier = TARGET_GALERIE . $image->getNom();
    //Si le fichier existe, on le supprime
    if(file_exists($fichier)){
     unlink($fichier);
    }
    header('Location: index.php?page=4');
    exit;
}
//Supprime une vidéo
if(isset($_POST["supprimerVideo"])){
    $video=$managerVideo->getVideo($_POST["numVideoASupprimer"]);
    $managerVideo->deleteVideo($video->getNum());
    //Fichier à supprimer
    $fichier = TARGET_VIDEO . $video->getNom();
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
      echo "<a class=\"fancybox\" href=\"" . $image->getSrc() . $image->getNom() . "\" data-fancybox-group=\"gallery\"><img src=\"" . $image->getSrc() . $image->getNom() . "\"alt=\"\" width=\"300\" height=\"200\"></a>";
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
            <input class="bouton" type="submit" name="formAjoutImage" value="Uploader" />
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
             <input class="bouton" type="submit" name="formAjoutVideo" value="Uploader" />
         </form>
     </div>
 <?php
 }
?>
