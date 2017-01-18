<p>© IUT du Limousin  DUT Informatique année 2016-2017</p>

<?php
if(isset($_SESSION["login"])){?>
    <form method="POST" action="#">
      <input type="color" id="couleurFooter">
      <input type="color" id="couleurFontPage">
      <input type="submit" value="valider" id="changerCouleur">
    </form>
    <a href="index.php?page=7">Déconnexion</a>
<?php
}else{?>
    <a href="index.php?page=6">Admin !</a>
<?php
}?>
