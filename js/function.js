//Fonction pour cacher ou afficher la nav en version mobile
function navBar(){
    var nav = $("nav");
    //Si on est en responsive
    if($('#boutonMenu').css("display") != "none"){
        nav.css('display', 'none');
    }else{
        nav.css('display', 'block');
    }
}
$(navBar);
$(window).resize(navBar);

$(function(){
    var nav = $("nav");
    $("#boutonMenu").bind("click", function(){
        nav.toggle("blind", 200);
    });
})

//Fonction pour afficher ou cacher la div d'ajout de logo de réseaux sociaux
$(function(){
    $("#boutonAjoutReseauSocial").on("click", function(){
        $("#divAjouterLogo").toggle(500);
        $("#boutonAjoutReseauSocial").toggleClass("bordureCarrée");
    });
});

//Fonction permettant de changer le margin-top des articles en fonction de la présence des boutons supprimer/modifier (responsive)
function marginTopArticle(){
    if( ( $(window).width() < "1000" && mobile == false ) || mobile == true){
        if($(".voletGestionArticle").length != 0){
            $('.divArticle').css('margin-top', 'calc(55px + 3vh)');
        }else{
            $('.divArticle').css('margin-top', '2vh');
        }
    }else{
        $('.divArticle').css('margin-top', '2vh');
    }
}
$(marginTopArticle);
$(window).resize(marginTopArticle);


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

$(document).ready(function()
{
   // On cache la zone de texte
   $('#formulaireAccueil').hide();
   // toggle() lorsque le lien avec l'ID #toggler est cliqué
   $('#boutonPlusFormulaireAjout').click(function()
   {
      $('#formulaireAccueil').toggle(400);
      return false;
   });
});

$(document).ready(function(){
   // On cache la zone de texte
   $('#formulaireArticle').hide();
   // toggle() lorsque le lien avec l'ID #toggler est cliqué
   $('#boutonPlusFormulaireAjout').click(function(){
      $('#formulaireArticle').toggle(400);
      return false;
   });
});

$(document).ready(function(){
   // On cache la zone de texte
   $('#formulaireEvenement').hide();
   // toggle() lorsque le lien avec l'ID #toggler est cliqué
   $('#boutonPlusFormulaireAjout').click(function(){
      $('#formulaireEvenement').toggle(400);
      return false;
   });
});

$(function(){
    $(".albumGalerie").bind("mouseenter mouseleave", function(){
        if($(window).width() > "1000"){
            $(".titreAlbum", this).fadeToggle(200).toggleClass("titreAlbumAfficher");
        }

    });
})

function fancyboxQuiMarche(){
    $('.fancybox').fancybox();
}

$( function($) {
  $.datepicker.regional['fr'] = {
      closeText: 'Fermer',
      prevText: '&#x3c;Préc',
      nextText: 'Suiv&#x3e;',
      currentText: 'Courant',
      monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin',
      'Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
      monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun',
      'Jul','Aoû','Sep','Oct','Nov','Déc'],
      dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
      dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
      dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
      weekHeader: 'Sm',
      //dateFormat: 'dd/mm/yy',
                dateFormat: 'dd/mm/yy',
      firstDay: 1,
      isRTL: false,
      showMonthAfterYear: false,
      yearSuffix: ''};
   $.datepicker.setDefaults($.datepicker.regional['fr']);
   $(".datepicker").datepicker();
});


function initEditText(){
  tinymce.init({
    selector : '.texteArea',
    language : 'fr_FR',
    plugins: [
      'advlist autosave autolink link image lists charmap preview hr emoticons spellchecker colorpicker ',
      'searchreplace wordcount visualchars fullscreen media imagetools',
      ' directionality emoticons template paste textcolor autoresize'
    ],
    images_upload_url: 'postAcceptor.php',
     automatic_uploads: true,
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | preview media fullpage | forecolor backcolor emoticons',
    autosave_ask_before_unload: false,
    spellchecker_language: 'fr_FR',
    resize: false
  });

}

//Fonction pour fixer la nav quand on scroll
$(function(){
  $(window).scroll(function () {//Au scroll dans la fenetre on déclenche la fonction
        if(mobile == false && $(window).width() > "1000"){
            if ($(this).scrollTop() > $('header').height()) { //si on a défilé de plus de 150px du haut vers le bas
                $('#corps').css("paddingTop", $('nav').height());
                $('nav').addClass("fixNavigation"); //on ajoute la classe "fixNavigation" à <div id="navigation">
                //$('#corps').addClass("fixNavigationHeader");

            } else {
                $('nav').removeClass("fixNavigation");//sinon on retire la classe "fixNavigation" à <div id="navigation">
                //$('#corps').removeClass("fixNavigationHeader");
                $('#corps').css("paddingTop", "0");
            }
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

  $(".boutonModifierFinal").click(function (e) {
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
    fancyboxQuiMarche();
    clickBoutonChangerCouleur();
    initEditText();
}


$(function(){
    $("#corps").css("paddingBottom", $("footer").outerHeight(true));
})

$(function(){
    $('.lienPersonneInscrite').on('click', function(){
        $("~ .divPersonneInscrite", this).toggle(200);
    })
})

$(window).resize(function(){
    $(function(){
        $("#corps").css("paddingBottom", $("footer").outerHeight(true));
    })
});
