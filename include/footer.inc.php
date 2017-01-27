
<!-- Plugin Facebook -->
<div class="divPluginReseauxSociaux">
    <div class="fb-page" data-href="https://www.facebook.com/Association-K%C3%A9lyan-940734619334207/?fref=ts" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false">
        <blockquote cite="https://www.facebook.com/Association-K%C3%A9lyan-940734619334207/?fref=ts" class="fb-xfbml-parse-ignore">
            <a href="https://www.facebook.com/Association-K%C3%A9lyan-940734619334207/?fref=ts">Association Kélyan</a>
        </blockquote>
    </div>
</div>

<p>© IUT du Limousin  DUT Informatique année 2016-2017</p>

<?php
if(isset($_SESSION["login"])){?>
    <form method="POST" action="#">
      <input type="color" id="couleurFooter">
      <input type="color" id="couleurFontPage">
      <input type="button" value="valider" id="changerCouleur">
    </form>
    <a href="index.php?page=7">Déconnexion</a>
<?php
}else{?>
    <a href="index.php?page=6">Admin !</a>
<?php
}?>
