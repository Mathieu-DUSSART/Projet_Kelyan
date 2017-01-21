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


 //Ajoute une image ou une vidéo
 if(isset($_POST["formAjoutImage"])){
     // On verifie si le champ est rempli
     print_r($_FILES['fichier']);
     if( !empty($_FILES['fichier']['name']) ){
         // Recuperation de l'extension du fichier
         $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
         // On verifie l'extension du fichier
         if(in_array(strtolower($extension),$tabExtImg)){
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
                 if(move_uploaded_file($_FILES['fichier']['tmp_name'], $target.$nomImage)){
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
                     $tabContenu["group_num"]=$_GET["album"];
                     $tabContenu["img_num"]=$managerImage->getImageByNom($nomImage);
                     $contenu=new Contenu($tabContenu);
                     $managerContenu->add($contenu);
                     $message = 'Upload réussi !';

                     header('Location: index.php?page=4&album=' . $_GET["album"]);
                     exit;
                 }else{
                     // Sinon on affiche une erreur systeme
                     $message = 'Problème lors de l\'upload !';
                 }
             }else{
                 $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
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
if(isset($_POST["numImageASupprimer"])){
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
if(isset($_POST["numVideoASupprimer"])){
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
<h1>Galerie</h1>
<h2>Album :</h2>

<?php
$groupTab=$managerGroup->getAllGroup();
$contenuTab = array();
if(!isset($_GET["album"])){
    foreach($groupTab as $group){
        $contenuTab = $managerContenu->getAllContenu($group->getGroupNum());
        if(!empty($contenuTab)){
            $image = $managerImage->getImage($contenuTab[0]->getImgNum());
            if(!$image->getType()){?>
                <div class="album">
                    <span class="titreAlbum"><?php echo $group->getGroupNom();?></span>
                    <?php
                    echo "<a href=\"index.php?page=4&album=" . $group->getGroupNum() . "\"><img src=\"" . $image->getSrc() . $image->getNom() . "\"alt=\"\" width=\"300\" height=\"200\"></a>";
                    if(isset($_SESSION["login"])){?>
                        <div class="supprimerImage">
                            <form class="supprimer" method="POST" action="#">
                                <input name="supprimerImage" class="boutonSupprimer" type="button" value="X">
                                <input class="num" name="numImageASupprimer" type="hidden" value="<?php echo $image->getNum(); ?>">
                            </form>
                        </div>
                    <?php
                    }?>
                </div>
            <?php
            }else{?>
                <div class="album">
                    <span class="titreAlbum"><?php echo $group->getGroupNom();?></span>
                    <?php
                    echo "<a href=\"index.php?page=4&album=" . $group->getGroupNum() . "\"><video src=\"" . $image->getSrc() . $image->getNom() . "\">" . $image->getDescription() . "</video></a>";
                    if(isset($_SESSION["login"])){?>
                        <div class="supprimerImage">
                            <form class="supprimer" method="POST" action="#">
                                <input class="boutonSupprimer" name="supprimerVideo" type="button" value="X">
                                <input class="num" name="numVideoASupprimer" type="hidden" value="<?php echo $image->getNum(); ?>">
                            </form>
                        </div>
                    <?php
                    }?>
                </div>
            <?php
            }
        }
    }
    if(isset($_SESSION["login"])){?>
        <h3>Ajouter un groupe </h3>
        <form method="POST" action="#">
            <?php
            if(isset($_POST["numGroupAModifier"]) && isset($_SESSION["login"])){
                $group=$managerGroup->getGroupByNum($_POST["numGroupAModifier"]);?>
                <input type="text" name="ModifierGroup" value="<?php echo $group->getGroupNom() ?>" >
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
}else{
    $contenuTab = $managerContenu->getAllContenu($_GET["album"]);
    foreach($contenuTab as $contenu){
        $image=$managerImage->getImage($contenu->getImgNum());

        if(!$image->getType()){?>
            <div class="img">
                <?php
                echo "<a class=\"fancybox\" href=\"" . $image->getSrc() . $image->getNom() . "\" data-fancybox-group=\"gallery\"><img src=\"" . $image->getSrc() . $image->getNom() . "\"alt=\"\" width=\"300\" height=\"200\"></a>";
                if(isset($_SESSION["login"])){?>
                    <div class="supprimerImage">
                        <form class="supprimer" method="POST" action="#">
                            <input class="boutonSupprimer" name="supprimerImage" type="button" value="X">
                            <input class="num" name="numImageASupprimer" type="hidden" value="<?php echo $image->getNum(); ?>">
                        </form>
                    </div>
                <?php
                }?>
            </div>
        <?php
        }else{
            echo" <div class=\"img\">";
            if(isset($_SESSION["login"])){?>
                <div class="supprimerVideo">
                    <form class="supprimer" method="POST" action="#">
                        <input class="boutonSupprimer" name="supprimerVideo" type="button" value="X">
                        <input class="num" name="numVideoASupprimer" type="hidden" value="<?php echo $image->getNum(); ?>">
                    </form>
                </div>
            <?php
            }
            echo "<video controls src=\"" . $image->getSrc() . $image->getNom() . "\">" . $image->getDescription() . "</video>";
            echo "</div>";
        }
    }
}
?>






<?php
//Permet d'ajouter une image ou un vidéo dans un album
if(isset($_SESSION["login"])){?>
    <div id="ajouterImageDansAlbum">
        <form enctype="multipart/form-data" action="#" method="post">
            <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Envoyer le fichier:</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />

            <input name="fichier" id="fichier_a_uploader" type="file" />
            <input id="browse-click" type="button" class="button" value="Parcourir"/>
            <p id="file-name" class="nomFichier"></p>

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
