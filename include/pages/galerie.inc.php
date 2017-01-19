<?php
 /************************************************************
  * Definition des constantes / tableaux et variables
  *************************************************************/


 // Tableaux de donnees
 $tabExtImg = array('jpg','gif','png','jpeg','mp4','avi','mkv','mpeg');    // Extensions autorisees
 $tabExtVideo = array('mp4','avi','mkv','mpeg');
 $infosImg = array();

 // Variables
 $extension = '';
 $message = '';
 $nomImage = '';


if(isset($_POST["formAjoutImage"])){
    // On verifie si le champ est rempli
    if( !empty($_FILES['fichier']['name']) ){
        // Recuperation de l'extension du fichier
        $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
        // On verifie l'extension du fichier
        if(in_array(strtolower($extension),$tabExtImg)){
            // On recupere les dimensions du fichier
          //  $infosImg = getimagesize($_FILES['fichier']['tmp_name']);
            // On verifie le type de l'image
          //  if($infosImg[2] >= 1 && $infosImg[2] <= 14){
                // On verifie les dimensions et taille de l'image
                //if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE)){
                  // Parcours du tableau d'erreurs
                  if(isset($_FILES['fichier']['error']) && UPLOAD_ERR_OK === $_FILES['fichier']['error']){
                    // On renomme le fichier
                    $nomImage = md5(uniqid()) .'.'. $extension;
                     // Si c'est OK, on teste l'upload
                     if(in_array(strtolower($extension),$tabExtVideo)){
                       $target=TARGET_VIDEO;
                     }else {
                       $target=TARGET_GALERIE;
                     }
                     echo "target";
                     echo $target;
                     if(move_uploaded_file($_FILES['fichier']['tmp_name'], $target.$nomImage))
                     {
                       $tabImg=Array();
                       if(in_array(strtolower($extension),$tabExtVideo)){
                        $tabImg["img_src"]="/Projet_Kelyan/video/";
                       }else{
                         $tabImg["img_src"]="/Projet_Kelyan/image/galerie/";
                       }
                       $tabImg["img_nom"]=$nomImage;
                       $tabImg["img_description"]=null;
                       $tabImg["img_lien"]=null;
                       if(in_array(strtolower($extension),$tabExtVideo)){
                        $tabImg["img_type"]=1;
                       }else{
                         $tabImg["img_type"]=0;
                       }
                       $image=new Image($tabImg);
                       $managerImage->add($image);
                       $tabContenu=Array();
                       $tabContenu["group_num"]=$_POST["groupePourImage"];
                       echo $tabContenu["group_num"];
                       $tabContenu["img_num"]=$managerImage->getImageByNom($nomImage);
                       echo "img_num";
                       echo  $tabContenu["img_num"];
                       $contenu=new Contenu($tabContenu);
                       $managerContenu->add($contenu);
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
                //   $message = 'Erreur dans les dimensions de l\'image !';
                // }
              //  }else{
                 // Sinon erreur sur le type de l'image
                // $message = 'Le fichier à uploader n\'est pas une image !';
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



 //Supprime une image
if(isset($_POST["supprimerImage"])){
    $image=$managerImage->getImage($_POST["numImageASupprimer"]);
    $managerContenu->deleteContenu($image->getNum());
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
    $video=$managerImage->getImage($_POST["numVideoASupprimer"]);
    $managerContenu->deleteContenu($video->getNum());
    $managerImage->deleteImage($video->getNum());
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
<link rel="stylesheet" type="text/css" href="fancyBox\fancyBox-master\source\jquery.fancybox.css?v=2.1.5" media="screen" />
<?php
  $groupTab=$managerGroup->getAllGroup();

  foreach($groupTab as $group){
    if(isset($_SESSION["login"])){?>
      <div class="supprimerGroup">
            <form method="POST" action="#">
                <input name="supprimerGroup" type="submit" value="X">
                <input name="numGroupASupprimer" type="hidden" value="<?php echo $group->getGroupNum(); ?>">
            </form>
        </div>
        <div class="modifierGroup">
              <form method="POST" action="#">
                  <input name="modifierGroup" type="submit" value="M">
                  <input name="numGroupAModifier" type="hidden" value="<?php echo $group->getGroupNum(); ?>">
              </form>
        </div>
    <?php
    }
    echo "<h2>" . $group->getGroupNom() . "</h2>";
    $contenuTab=$managerContenu->getAllContenu($group->getGroupNum());
    foreach($contenuTab as $contenu){
      $image=$managerImage->getImage($contenu->getImgNum());

      if(!$image->getType()){
          echo"<div class=\"img\">";
        echo "<a class=\"fancybox\" href=\"" . $image->getSrc() . $image->getNom() . "\" data-fancybox-group=\"gallery\"><img src=\"" . $image->getSrc() . $image->getNom() . "\"alt=\"\" width=\"300\" height=\"200\"></a>";
        if(isset($_SESSION["login"])){?>
          <div class="supprimerImage">
                <form method="POST" action="#">
                    <input name="supprimerImage" type="submit" value="X">
                    <input name="numImageASupprimer" type="hidden" value="<?php echo $image->getNum(); ?>">
                </form>
            </div>
        <?php
        }
        echo"</div>";
      }else{
          echo" <div class=\"img\">";
        if(isset($_SESSION["login"])){?>
            <div class="supprimerImage">
                <form method="POST" action="#">
                    <input name="supprimerVideo" type="submit" value="X">
                    <input name="numVideoASupprimer" type="hidden" value="<?php echo $image->getNum(); ?>">
                </form>
            </div>
        <?php
        }
        echo "<video controls src=\"" . $image->getSrc() . $image->getNom() . "\">" . $image->getDescription() . "</video>";
          echo "</div>";
      }

    }
  }
  if(isset($_SESSION["login"])){
  ?>
  <h3>Ajouter un groupe </h3>
  <form method="POST" action="#"><?php
    if(isset($_POST["numGroupAModifier"]) && isset($_SESSION["login"])){
      $group=$managerGroup->getGroupByNum($_POST["numGroupAModifier"]);
        ?><input type="text" name="ModifierGroup" value="<?php echo $group->getGroupNom() ?>" >
        <input type="hidden" name="ModifierGroupNum" value="<?php echo $group->getGroupNum() ?>" >
        <input name="AjoutGroupeB" type="submit" value="Modifier un groupe"><?php
    }
    else{
      echo"<input type=\"text\" name=\"AjoutGroupe\" >";
      echo "<input name=\"AjoutGroupeB\" type=\"submit\" value=\"Ajouter un groupe\">";
    }?>

  </form>

  <?php
}
  ?>






<?php

if(isset($_SESSION["login"])){?>
    <div id="ajouterImage">
        <form enctype="multipart/form-data" action="#" method="post">
            <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Envoyer le fichier</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
            <input name="fichier" type="file" id="fichier_a_uploader" />
            <select name="groupePourImage">
              <?php
              $groupTab1=$managerGroup->getAllGroup();
              foreach ($groupTab1 as $groupe) {
                echo "<option name=\"GroupePourImage\" value=\"" . $groupe->getGroupNum() ."\">" .  $groupe->getGroupNom() . "</option>";
              }
              echo "</select>";
               ?>
            <input class="bouton" type="submit" name="formAjoutImage" value="Uploader" />
        </form>
    </div>

 <?php
 }?>

<!-------------------------------------------------------------------Video------------------------------------------------------------------------------------------------>

 <?php

 if(isset($_POST["AjoutGroupe"]) && isset($_SESSION["login"])){
   $newGroup=array();
   $newGroup["group_nom"]=$_POST["AjoutGroupe"];
   $group=new Groupe($newGroup);
   $managerGroup->add($group);
 }

 if(isset($_POST["ModifierGroup"]) && isset($_SESSION["login"])){
   $group=$managerGroup->getGroupByNum($_POST["ModifierGroupNum"]);
   echo "test modifier";
   echo $group->getGroupNum();
   echo $_POST["ModifierGroup"];
   $managerGroup->modifierGroupe($group->getGroupNum(),$_POST["ModifierGroup"]);
 }
if(isset($_POST["numGroupASupprimer"]) && isset($_SESSION["login"])){

  $managerGroup->deleteGroup($_POST["numGroupASupprimer"]);
}

?>
