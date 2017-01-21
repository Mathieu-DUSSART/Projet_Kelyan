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
  var footer = document.getElementById("footer");
  footer.style.backgroundColor=couleurFooter;
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

$(function(){
    $(".album").bind("mouseenter mouseleave", function(){
        $(".titreAlbum", this).fadeToggle(200).toggleClass("titreAlbumAfficher");
    });
})

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



function centrerNav(){
    var largeur_fenetre = $(window).width();

    if(largeur_fenetre > "1000"){
        var paddingGauche = largeurNav - (sommeLargeur-largeurBouton);
        $("nav ul").css( "padding-left", paddingGauche/2 );
    }else{
        $("nav ul").css( "padding-left", "0");
    }
}

function calculNav(){
    sommeLargeur = 0;
    nbElem = $('nav ul li').length;
    largeurNav = $('nav').width();
    largeurBouton = $('#ongletAjoutPage').width() + $('#menu').width();

    $("nav li").each(function(){
        sommeLargeur = sommeLargeur + $(this).width();

        if(sommeLargeur > (largeurNav-largeurBouton) && $(this).attr("id")!="menu" && $(this).attr("id")!="ongletAjoutPage"){
            //test(this);
        }else{

        }
    });
}

$(function(){
    calculNav();
    centrerNav();
});

$(window).resize(function(){
    calculNav();
    centrerNav();
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

//Fonction pour fixer la nav quand on scroll
$(function(){
  $(window).scroll(function () {//Au scroll dans la fenetre on déclenche la fonction
     if ($(this).scrollTop() > $('header').height()) { //si on a défilé de plus de 150px du haut vers le bas
         $('nav').addClass("fixNavigation"); //on ajoute la classe "fixNavigation" à <div id="navigation">
         $('#corps').addClass("fixNavigationHeader");
     } else {
         $('nav').removeClass("fixNavigation");//sinon on retire la classe "fixNavigation" à <div id="navigation">
         $('#corps').removeClass("fixNavigationHeader");
     }
  });
});

//Fonction pour cacher ou afficher la nav en version mobile
$(function(){
    $("#boutonMenu").bind("click", function(){
        var nav = $("nav");

        if(nav.hasClass("cacherNav")){
            nav.removeClass("cacherNav");
        }else{
            nav.addClass("cacherNav");
        }
    });
});

//popup de confirmation de suppression
$(document).ready(function() {
  var dialogSuppr = $('#dialog-confirm-suppr');

  $(".boutonSupprimer").click(function (e) {
    e.preventDefault();
    numObjet = $(this).next("input").val();
    dialogSuppr.dialog("open");
  });
  dialogSuppr.dialog({
     resizable: false,
     draggable : false,
     height:200,
     width:500,
     autoOpen: false,
     modal: true,
     buttons: {
         "Oui": function() {
           $(".supprimer").each(function(){
             if($("input", this).next(".num").val()==numObjet){
                $("#ok").slideUp();
               $(this).submit();
             }
           });
           $( this ).dialog( "close" );

         },
         "Annuler": function() {
             $( this ).dialog( "close" );
         }
      }
 });

//popup de confirmation de modification
  var dialogModif = $('#dialog-confirm-modif');

  $(".boutonModifier").click(function (e) {
    e.preventDefault();
    dialogModif.dialog("open");
  });

  dialogModif.dialog({
     resizable: false,
     draggable : false,
     height:200,
     width:500,
     autoOpen: false,
     modal: true,
     buttons: {
         "Oui": function() {

           $(".modifier").submit();
           $( this ).dialog( "close" );
         },
         "Annuler": function() {
             $( this ).dialog( "close" );
         }
      }
 });
});

window.onload=function(){
    //test();
    clickBoutonAfficherMenuDeroulant();
    fancyboxQuiMarche();
    clickBoutonAjoutPage();
    clickBoutonAjoutLogoReseauxSociaux();
    clickBoutonChangerCouleur();
    initEditText();
}

$(window).load(function () {
    var intervalFunc = function () {
        $('#file-name').html($('#fichier_a_uploader').val());
    };
    $('#browse-click').on('click', function () { // use .live() for older versions of jQuery
        $('#fichier_a_uploader').click();
        setInterval(intervalFunc, 1);
        return false;
    });
});
