function ajouterPage(){
    var div = document.getElementById("divAjoutPage");
    if(div.style.display=="block"){
        div.style.display="none";
    }else{
        div.style.display="block";
    }
}

function clickBoutonAjoutPage(){
    var bouton = document.getElementById("boutonAjoutPage");
     if(bouton != null){
    bouton.addEventListener("click", ajouterPage, false);
  }
}

function ajouterLogoReseauxSociaux(){
    var div = document.getElementById("divAjouterLogo");
    if(div.style.display=="block"){
        div.style.display="none";
    }else{
        div.style.display="block";
    }
}

function clickBoutonAjoutLogoReseauxSociaux(){
    var bouton = document.getElementById("boutonAjoutReseauSocial");
     if(bouton != null){
    bouton.addEventListener("click", ajouterLogoReseauxSociaux, false);
  }
}

function changerCouleur(){
  var couleurBackGround = document.getElementById("couleurFontPage").value;
  var couleurFooter = document.getElementById("couleurFooter").value;
  var body = document.getElementTagName("body");
  var footer = document.getElementTagName("footer");
  footer.style.background-color=couleurFooter;
  body.style.
}

function clickBoutonChangerCouleur(){
  var bouton = document.getElementById("changerCouleur");
  if(bouton != null){
    bouton.addEventListener("click", changerCouleur, false);
  }
}

/*$(document).ready(function()
{
   // On cache la zone de texte
   $('fieldset').hide();
   // toggle() lorsque le lien avec l'ID #toggler est cliqué
   $('a#boutonInscrire').click(function()
  {
      $('fieldset').toggle(400);
      return false;
   });
});*/

function fancyboxQuiMarche(){
    $('.fancybox').fancybox();
}

$( function() {
  $( ".datepicker" ).datepicker({ dateFormat: "dd/mm/yy" });
} );


}
window.onload=function(){
    fancyboxQuiMarche();
    clickBoutonAjoutPage();
    clickBoutonAjoutLogoReseauxSociaux();
    clickBoutonChangerCouleur();
}