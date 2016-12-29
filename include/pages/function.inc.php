<?php
//Fonction qui renvoie le nom du mois en fonction de son numéro
function getMois($numMois){
    switch($numMois){
        case '1' : $mois = "Janvier";
        break;
        case '2' : $mois = "Février";
        break;
        case '3' : $mois = "Mars";
        break;
        case '4' : $mois = "Avril";
        break;
        case '5' : $mois = "Mai";
        break;
        case '6' : $mois = "Juin";
        break;
        case '7' : $mois = "Juillet";
        break;
        case '8' : $mois = "Août";
        break;
        case '9' : $mois = "Septembre";
        break;
        case '10' : $mois = "Octobre";
        break;
        case '11' : $mois = "Novembre";
        break;
        case '12' : $mois = "Décembre";
        break;
    }
    return $mois;
}

//Fonction qui prend une chaine de caractère en paramètre
//et qui renvoie la chaine de caractère en remplaçant les caractères accentués
//par des caractères normaux
function strRemoveAccent($string){
    $accent = array("@","À","Á","Â","Ã","Ä","Å","Ç","È","É","Ê","Ë","Ì","Í","Î","Ï","Ò","Ó","Ô","Õ","Ö","Ù","Ú","Û","Ü","Ý","à","á","â","ã","ä","å","ç","è","é","ê","ë","ì","í","î","ï","ð","ò","ó","ô","õ","ö","ù","ú","û","ü","ý","ÿ");
    $sansAccent = array("a","A","A","A","A","A","A","C","E","E","E","E","I","I","I","I","O","O","O","O","O","U","U","U","U","Y","a","a","a","a","a","a","c","e","e","e","e","i","i","i","i","o","o","o","o","o","o","u","u","u","u","y","y");

    return str_replace($accent, $sansAccent, $string);
}
?>
