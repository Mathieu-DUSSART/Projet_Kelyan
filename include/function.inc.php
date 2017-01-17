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

/*
Fonction qui prend une chaine de caractère en paramètre
et qui renvoie la chaine de caractère en remplaçant les caractères accentués
par des caractères normaux
Paramètre :
    - $string : la chaine de caractère
Retourne : la chaine de caractère sans caractères accentués
*/
function strRemoveAccent($string){
    $accent = array("@","À","Á","Â","Ã","Ä","Å","Ç","È","É","Ê","Ë","Ì","Í","Î","Ï","Ò","Ó","Ô","Õ","Ö","Ù","Ú","Û","Ü","Ý","à","á","â","ã","ä","å","ç","è","é","ê","ë","ì","í","î","ï","ð","ò","ó","ô","õ","ö","ù","ú","û","ü","ý","ÿ");
    $sansAccent = array("a","A","A","A","A","A","A","C","E","E","E","E","I","I","I","I","O","O","O","O","O","U","U","U","U","Y","a","a","a","a","a","a","c","e","e","e","e","i","i","i","i","o","o","o","o","o","o","u","u","u","u","y","y");

    return str_replace($accent, $sansAccent, $string);
}

/*
Fonction qui crypte un mot de passe
Paramètre :
    -$password : le mot de passe à crypter
Retourne : le mot de passe crypté
*/
function crypterPassword($password){
    $salt="48@!alsd";
    $password_crypte = sha1(sha1($password).$salt);

    return $password_crypte;
}

function getEnglishDate($date){
    $membres = explode('/', $date);
    $date = $membres[2].'-'.$membres[1].'-'.$membres[0];
    return $date;
}

//On définie le fuseau horaire sur Europe/Paris.
date_default_timezone_set('Europe/Paris');

function getFrenchDate($date){
    $membres = explode('-', $date);
    $date = $membres[2].'/'.$membres[1].'/'.$membres[0];
    return $date;
}
?>
