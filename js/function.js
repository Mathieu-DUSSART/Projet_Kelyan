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

jQuery(document).ready(function()
{
   // On cache la zone de texte
   jQuery('fieldset').hide();
   // toggle() lorsque le lien avec l'ID #toggler est cliqué
   jQuery('a#boutonInscrire').click(function()
  {
      jQuery('fieldset').toggle(400);
      return false;
   });
});

function fancyboxQuiMarche(){
    $('.fancybox').fancybox();
}

window.onload=function(){
   fancyboxQuiMarche();
    clickBoutonAjoutPage();
}
