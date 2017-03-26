<?php
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
                         $tabImg["img_src"]="video/";
                     }else{
                         $tabImg["img_src"]="image/galerie/";
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
    $managerContenu->deleteContenu($_GET["album"], $image->getNum());
    $managerImage->deleteImage($image->getNum());
    //Fichier à supprimer
    $fichier = TARGET_GALERIE . $image->getNom();
    //Si le fichier existe, on le supprime
    if(file_exists($fichier)){
     unlink($fichier);
    }
    header('Location: index.php?page=4&album=' . $_GET["album"]);
    exit;
}

//Supprime une vidéo
if(isset($_POST["numVideoASupprimer"])){
    $video=$managerImage->getImage($_POST["numVideoASupprimer"]);
    $managerContenu->deleteContenu($_GET["album"], $video->getNum());
    $managerImage->deleteImage($video->getNum());
    //Fichier à supprimer
    $fichier = TARGET_VIDEO . $video->getNom();
    //Si le fichier existe, on le supprime
    if(file_exists($fichier)){
     unlink($fichier);
    }
    header('Location: index.php?page=4&album=' . $_GET["album"]);
    exit;
}

if( !empty($message) ){
    echo '<p>',"\n";
    echo "\t\t<strong>", htmlspecialchars($message) ,"</strong>\n";
    echo "\t</p>\n\n";
}

//Ajoute un album
if(isset($_POST["AjoutGroupe"]) && isset($_SESSION["login"])){
   $newGroup=array();
   $newGroup["group_nom"] = $_POST["AjoutGroupe"];
   $group = new Groupe($newGroup);
   $managerGroup->add($group);
}

//Modifie un album
if(isset($_POST["ModifierGroup"]) && isset($_SESSION["login"])){
    $group=$managerGroup->getGroupByNum($_POST["ModifierGroupNum"]);
    echo $group->getGroupNum();
    echo $_POST["ModifierGroup"];
    $managerGroup->modifierGroupe($group->getGroupNum(), $_POST["ModifierGroup"]);
}

//Supprime un album
if(isset($_POST["numGroupASupprimer"]) && isset($_SESSION["login"])){
    $tabImg = $managerContenu->getImgDuGroupe($_POST["numGroupASupprimer"]);
    foreach ($tabImg as $image){
        $managerContenu->deleteContenu($_POST["numGroupASupprimer"], $image->getNum());
        $imageASuppr = $managerImage->getImage($image->getNum());
        $managerImage->deleteImage($image->getNum());

        if(!$imageASuppr->getType()){
            $fichier = TARGET_GALERIE . $imageASuppr->getNom();
        }else{
            $fichier = TARGET_VIDEO . $imageASuppr->getNom();
        }

        if(file_exists($fichier)){
            unlink($fichier);
        }
    }

    $managerGroup->deleteGroup($_POST["numGroupASupprimer"]);
}



?>
<h1>Galerie</h1>
<div id="divTitreAlbum">

<?php
$groupTab=$managerGroup->getAllGroup();
$contenuTab = array();
if(!isset($_GET["album"])){ //Affiche tous les albums ?>
        <a href="index.php?page=4">Album :</a>
    </div>
    <?php
    foreach($groupTab as $group){
        $contenuTab = $managerContenu->getAllContenu($group->getGroupNum());
        if(!empty($contenuTab)){  //Si l'album n'est pas vide, on affiche l'album avec sa première photo
            $image = $managerImage->getImage($contenuTab[0]->getImgNum());
            if(!$image->getType()){ //S'il s'agit d'une image?>
                <div class="albumGalerie">
                    <?php
                    echo "<a href=\"index.php?page=4&album=" . $group->getGroupNum() . "\"><span class=\"titreAlbum\">" . $group->getGroupNom() . "</span><img src=\"" . $image->getSrc() . $image->getNom() . "\" alt=\"\"></a>";
                    if(isset($_SESSION["login"])){?>
                        <div class="supprimerImageVideo">
                            <form class="supprimer" method="POST" action="#">
                                <input name="supprimerImage " class="boutonSupprimer input_btn1" type="button">
                                <input class="num" name="numGroupASupprimer" type="hidden" value="<?php echo $group->getGroupNum(); ?>">
                            </form>
                        </div>
                    <?php
                    }?>
                </div>
            <?php
        }else{ //S'il s'agit d'une vidéo?>
                <div class="albumGalerie">
                    <?php
                    echo "<a href=\"index.php?page=4&album=" . $group->getGroupNum() . "\"><span class=\"titreAlbum\">" . $group->getGroupNom() . "</span><video src=\"" . $image->getSrc() . $image->getNom() . "\">" . $image->getDescription() . "</video></a>";
                    if(isset($_SESSION["login"])){?>
                        <div class="supprimerImageVideo">
                            <form class="supprimer" method="POST" action="#">
                                <input class="boutonSupprimer input_btn1" name="supprimerVideo" type="button">
                                <input class="num" name="numGroupASupprimer" type="hidden" value="<?php echo $group->getGroupNum(); ?>">
                            </form>
                        </div>
                    <?php
                    }?>
                </div>
            <?php
            }
        }elseif(isset($_SESSION["login"])){ //Si l'album est vide, on affiche l'album?>
            <div class="albumGalerie">
                <?php
                echo "<a href=\"index.php?page=4&album=" . $group->getGroupNum() . "\"><span class=\"titreAlbum\">" . $group->getGroupNom() . "</span><div class=\"albumVide\"></div></a>";
                if(isset($_SESSION["login"])){?>
                    <div class="supprimerImageVideo">
                        <form class="supprimer" method="POST" action="#">
                            <input name="supprimerImage input_btn1" class="boutonSupprimer" type="button">
                            <input class="num" name="numGroupASupprimer" type="hidden" value="<?php echo $group->getGroupNum(); ?>">
                        </form>
                    </div>
                <?php
                }?>
            </div>
        <?php
        }
    }
    //Formulaire d'ajout d'album
    if(isset($_SESSION["login"])){?>
        <form id="ajouterAlbum" method="POST" action="#">
            <?php
            if(isset($_POST["numGroupAModifier"]) && isset($_SESSION["login"])){
                $group=$managerGroup->getGroupByNum($_POST["numGroupAModifier"]);?>
                <input type="text" name="ModifierGroup" value="<?php echo $group->getGroupNom() ?>" >
                <input type="hidden" name="ModifierGroupNum" value="<?php echo $group->getGroupNum() ?>" >
                <input name="AjoutGroupeB" type="submit" value="Modifier un groupe"><?php
            }else{?>
                <input type="text" name="AjoutGroupe" placeholder="Nom de l'album" required>
                <input type="submit" name="AjoutGroupeB" value="Créer l'album">
            <?php
            }?>
        </form>
        <?php
    }
}else{ //Affiche les images de l'album sélectionné
    $contenuTab = $managerContenu->getAllContenu($_GET["album"]);
    $album = $managerGroup->getGroupByNum($_GET["album"]);?>
        <a href="index.php?page=4">&larr; Albums :</a>
        <span class="nomAlbum"><?php echo $album->getGroupNom();?></span>
    </div>
    <?php
    foreach($contenuTab as $contenu){
        $image=$managerImage->getImage($contenu->getImgNum());

        if(!$image->getType()){?>
            <div class="imgGalerie">
                <?php
                echo "<a class=\"fancybox\" href=\"" . $image->getSrc() . $image->getNom() . "\" data-fancybox-group=\"gallery\"><img src=\"" . $image->getSrc() . $image->getNom() . "\" alt=\"\"></a>";
                if(isset($_SESSION["login"])){?>
                    <div class="supprimerImageVideo">
                        <form class="supprimer" method="POST" action="#">
                            <input class="boutonSupprimer input_btn1" name="supprimerImage" type="button">
                            <input class="num" name="numImageASupprimer" type="hidden" value="<?php echo $image->getNum(); ?>">
                        </form>
                    </div>
                <?php
                }?>
            </div>
        <?php
        }else{?>
            <div class="imgGalerie">
                <?php
                echo "<video controls src=\"" . $image->getSrc() . $image->getNom() . "\">" . $image->getDescription() . "</video>";
                if(isset($_SESSION["login"])){?>
                    <div class="supprimerImageVideo">
                        <form class="supprimer" method="POST" action="#">
                            <input class="boutonSupprimer input_btn1" name="supprimerVideo" type="button">
                            <input class="num" name="numVideoASupprimer" type="hidden" value="<?php echo $image->getNum(); ?>">
                        </form>
                    </div>
                <?php
                }?>
            </div>
        <?php
        }
    }
    //Permet d'ajouter une image ou un vidéo dans un album
    if(isset($_SESSION["login"])){?>
        <div id="ajouterImageDansAlbum">
            <form enctype="multipart/form-data" action="#" method="post">
                <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Envoyer le fichier:</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />

                <label id="boutonParcourirFichier">
                    <input name="fichier" id="fichier_a_uploader" type="file" />
                    Parcourir
                </label>
                <p id="nomFichierAUploader">Aucun fichier choisi</p>

                <input class="bouton" type="submit" name="formAjoutImage" value="Uploader" />
            </form>
        </div>
     <?php
     }
}
?>
