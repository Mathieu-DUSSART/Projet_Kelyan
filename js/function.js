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

function afficherMenuDeroulant(){
    var div = document.getElementById("menuDeroulant");
    if(div.style.display=="block"){
        div.style.display="none";
    }else{
        div.style.display="block";
    }
}

function clickBoutonAfficherMenuDeroulant(){
    var bouton = document.getElementById("menu");
     if(bouton != null){
    bouton.addEventListener("click", afficherMenuDeroulant, false);
  }
}

function changerCouleur(){
  var couleurBackGround = document.getElementById("couleurFontPage").value;
  var couleurFooter = document.getElementById("couleurFooter").value;
  //var body = document.getElementTagName("body");
  //var footer = document.getElementTagName("footer");
  document.footer.style.backgroundColor=couleurFooter;
  document.body.style.backgroundColor=couleurBackGround;
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

function initEditText(){
  tinymce.init({
    selector : '.texteArea',
    plugins: [
      'advlist autosave autolink link image lists charmap preview hr emoticons spellchecker colorpicker ',
      'searchreplace wordcount visualchars fullscreen media imagetools',
      ' directionality emoticons template paste textcolor autoresize'
    ],
    images_upload_url: 'postAcceptor.php',
     automatic_uploads: true,
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | preview media fullpage | forecolor backcolor emoticons',
    autosave_ask_before_unload: false,
    spellchecker_language: 'fr',

  });

}




$(function(){
    var sommeLargeur = 0;
    var nbElem = $('nav ul li').length;
    var largeurNav = $('nav').width();
    var largeurBouton = $('#ongletAjoutPage').width() + $('#menu').width();
    $("nav li").each(function(){
        sommeLargeur = sommeLargeur + $(this).width();
        //alert(sommeLargeur + " tet " + (largeurNav))
        if(sommeLargeur > (largeurNav-largeurBouton) && $(this).attr("id")!="menu" && $(this).attr("id")!="ongletAjoutPage"){
            //alert(sommeLargeur + " tet " + (largeurNav-largeurBouton));
            //alert(sommeLargeur + " coucou " + $('nav').width());
            //alert(sommeLargeur);
            //alert(compteur);
            test(this);
        }else{
            //alert(sommeLargeur);
            //alert("oops");
            //test(compteur);
        }
    });

    var paddingGauche = largeurNav - (sommeLargeur-largeurBouton);
    $("nav ul").css( "padding-left", paddingGauche/2 );
});

function test(onglet){
    //var onglet = $('nav ul li').get(n);
    $("#menuDeroulant").append(onglet);
    /*onglet.style.position = "absolute";
    onglet.style.bottom = "-8vh";
    onglet.style.right = "0";*/
    /*$("#menuDeroulant").append(onglet);
    var onglet2 = $('nav ul li').get(2);
    $("#menuDeroulant").append(onglet2);
    var onglet3 = $('nav ul li').get(3);
    $("#menuDeroulant").append(onglet3);*/
}


window.onload=function(){
    //test();
    clickBoutonAfficherMenuDeroulant();
    fancyboxQuiMarche();
    clickBoutonAjoutPage();
    clickBoutonAjoutLogoReseauxSociaux();
    clickBoutonChangerCouleur();
    initEditText();
}
