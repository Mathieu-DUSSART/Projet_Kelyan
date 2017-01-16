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
    bouton.addEventListener("click", ajouterPage, false);
}

function ajouterReseauSocial(){
    var div = document.getElementById("divAjouterLogo");
    if(div.style.display=="block"){
        div.style.display="none";
    }else{
        div.style.display="block";
    }
}

function clickBoutonAjoutLogo(){
    var bouton = document.getElementById("boutonAjoutReseauSocial");
    bouton.addEventListener("click", ajouterReseauSocial, false);
}

window.onload=function(){
    clickBoutonAjoutPage();
    clickBoutonAjoutLogo();
}
