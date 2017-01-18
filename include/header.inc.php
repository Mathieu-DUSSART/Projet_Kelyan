
<!-- Add jQuery library -->
	<script type="text/javascript" src="fancyBox-master\lib\jquery-1.10.2.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="fancyBox-master\lib\jquery.mousewheel.pack.js?v=3.1.3"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="fancyBox-master\source\jquery.fancybox.pack.js?v=2.1.5"></script>

  <?php
  // Constantes
  define('TARGET_RESEAUX_SOCIAUX', 'image/reseaux_sociaux/');    // Repertoire cible
  define('TARGET_GALERIE', 'image/galerie/');    // Repertoire cible
  define('TARGET_VIDEO', 'video/');    // Repertoire cible
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
      if( !empty($_FILES['fichierReseauxSociaux']['name']) ){
          // Recuperation de l'extension du fichier
          $extension  = pathinfo($_FILES['fichierReseauxSociaux']['name'], PATHINFO_EXTENSION);
          // On verifie l'extension du fichier
          if(in_array(strtolower($extension),$tabExt)){
              // On recupere les dimensions du fichier
              $infosImg = getimagesize($_FILES['fichierReseauxSociaux']['tmp_name']);
              // On verifie le type de l'image
              if($infosImg[2] >= 1 && $infosImg[2] <= 14){
                  // On verifie les dimensions et taille de l'image
                  if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichierReseauxSociaux']['tmp_name']) <= MAX_SIZE)){
                    // Parcours du tableau d'erreurs
                    if(isset($_FILES['fichierReseauxSociaux']['error']) && UPLOAD_ERR_OK === $_FILES['fichierReseauxSociaux']['error']){
                      // On renomme le fichier
                      $nomImage = md5(uniqid()) .'.'. $extension;
                       // Si c'est OK, on teste l'upload
                       if(move_uploaded_file($_FILES['fichierReseauxSociaux']['tmp_name'], TARGET_RESEAUX_SOCIAUX.$nomImage))
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
  //Supprime un logo
  if(isset($_POST["supprimerLogo"])){
     $image=$managerImage->getImage($_POST["numLogoASupprimer"]);
     $managerImage->deleteImage($image->getNum());
     //Fichier à supprimer
     $fichier = TARGET_RESEAUX_SOCIAUX . $image->getNom();
     //Si le fichier existe, on le supprime
     if(file_exists($fichier)){
      unlink($fichier);
     }
     header('Location: index.php?page=' . $_GET["page"]);
     exit;
 }?>
  <div id="divReseauxSociaux">
	  <?php
	  //Récupère tous les logos des réseaux sociaux
	  foreach ($managerImage->getAllImage("/Projet_Kelyan/image/reseaux_sociaux/") as $image) { ?>
		<div class="divLogoReseauxSociaux">
	    	<?php
			echo "<a href=\"" . $image->getLien() . "\"><img class=\"logoReseauxSociaux\" src=\"" . $image->getSrc() . $image->getNom() . "\"alt=\"\"></a>";
			if(isset($_SESSION["login"])){ ?>
				<div class="supprimerLogo">
					<form method="POST" action="#">
						<input name="supprimerLogo" type="submit" value="X">
						<input name="numLogoASupprimer" type="hidden" value="<?php echo $image->getNum(); ?>">
					</form>
				</div>
		    <?php
			} ?>
		</div>
		<?php
		}
		//Si on est connecté en admin, on peut ajouter un réseau social
		if(isset($_SESSION["login"])){?>
			<div id="divAjoutReseauxSociaux">
				<input id="boutonAjoutReseauSocial" type="button" value="+">
				<div id="divAjouterLogo">
					<form enctype="multipart/form-data" id="ajouterArticle" method="POST" action="#">
						<label>Logo:</label>
						<input name="fichierReseauxSociaux" type="file" id="fichier_a_uploader" />
						<label>Lien: </label>
						<input type="url" name="lien">
						<input type="submit" value="Valider">
					</form>
				</div>
			</div>
			<?php
		}?>
		<input id="boutonInscrireNews" type="button" value="S'inscrire à la newsletter">
	</div>

	<img id="logo" src="image/logo.jpeg" alt="">
	<h1>Association Kélyan</h1>
