<?php
if( isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["mail"]) ){
    $tabPers = Array();
    $tabPers["per_nom"] = $_POST["nom"];
    $tabPers["per_prenom"] = $_POST["prenom"];
    $tabPers["per_mail"] = $_POST["mail"];
    $personne = new Personne($tabPers);

    if($managerPersonne->existe($personne->getPerMail())){
        $personne = $managerPersonne->getPersonne($personne->getPerMail());
    }else{
        $managerPersonne->add($personne);
    }

    if($managerPersonne->personneDejaInscriteNews($personne)){
        echo "déjà inscrite";
    }else{
        $managerPersonne->inscrireNews($personne);
        echo "Inscription terminée";
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////Verif Mail NewsLetter/////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $email = $_POST["mail"];

    $cle = md5(microtime(TRUE)*100000);
    $managerPersonne->setCle($email,$cle);
    $sujet="Activer votre mail";
    $entete="From: inscription@kelyan.com";
    $message='Bienvenue sur VotreSite,

    Pour activer votre compte, veuillez cliquer sur le lien ci dessous
    ou copier/coller dans votre navigateur internet.

    localhost/Projet_Kelyan/index.php?page=11&log='.urlencode($email).'&cle='.urlencode($cle).'


    ---------------
    Ceci est un mail automatique, Merci de ne pas y répondre.';

    //mail($email, $sujet, $message, $entete);
}


 ?>

<h1>Inscription à la newsletter</h1>

<form id="formContact" method="POST" action="#">
    <label>Nom: </label>
    <input type="text" name="nom" required>

    <label>Prenom: </label>
    <input type="text" name="prenom" required>

    <label>Mail: </label>
    <input type="email" name="mail" required>

    <input id="boutonInscription" type="submit" value="S'inscrire">
</form>
