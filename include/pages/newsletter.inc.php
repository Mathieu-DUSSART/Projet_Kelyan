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
}


 ?>

<h1>Inscription à la newsletter</h1>

<form id="formContact" method="POST" action="#">
    <label>Nom: </label>
    <input type="text" name="nom" required>
    <br>

    <label>Prenom: </label>
    <input type="text" name="prenom" required>
    <br>

    <label>Mail: </label>
    <input type="email" name="mail" required>
    <br>

    <input id="boutonInscription" type="submit" value="S'inscrire">
</form>
