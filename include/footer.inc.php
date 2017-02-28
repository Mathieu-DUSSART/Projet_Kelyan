
<div id="divReseauxSociaux">
    <?php
    //Récupère tous les logos des réseaux sociaux
    foreach ($managerImage->getAllImage("image/reseaux_sociaux/") as $image) { ?>
      <div class="divLogoReseauxSociaux">
          <?php
          echo "<a href=\"" . $image->getLien() . "\"><img class=\"logoReseauxSociaux\" src=\"" . $image->getSrc() . $image->getNom() . "\" alt=\"\"></a>";

          if(isset($_SESSION["login"])){?>
              <div class="supprimerLogo">
                  <form class="supprimer" method="POST" action="#">
                      <input name="supprimerLogo " class="boutonSupprimer input_btn1" type="button">
                      <input class="num" name="numLogoASupprimer" type="hidden" value="<?php echo $image->getNum(); ?>">
                  </form>
              </div>
          <?php
          }?>
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
                      <input type="url" name="lien" value="http://">
                      <input type="submit" value="Valider">
                  </form>
              </div>
          </div>
          <?php
      }?>
</div>

<p>© IUT du Limousin  DUT Informatique année 2016-2017</p>
<a id="mentions" href="./include/pages/mention.html">Mentions légales</a>

<?php
if(isset($_SESSION["login"])){?>
    <!--<form method="POST" action="#">
      <input type="color" id="couleurFooter">
      <input type="color" id="couleurFontPage">
      <input type="button" value="valider" id="changerCouleur">
  </form>-->
    <a id="connexion" href="index.php?page=7">Déconnexion</a>
<?php
}else{?>
    <a id="connexion" href="index.php?page=6">Admin !</a>
<?php
}?>
