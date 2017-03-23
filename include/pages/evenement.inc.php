<?php
//Ajoute un évènement
if(isset($_POST["titre"])){
    $tabEvent=Array();
    $tabEvent["event_titre"]=$_POST["titre"];
    $date= getEnglishDate($_POST["date"]);
    $tabEvent["event_date"]=$date;
    $tabEvent["event_heure"]=$_POST["heure"];
    $tabEvent["event_texte"]=$_POST["texte"];
    $tabEvent["event_ville"]=$_POST["ville"];
    $evenement=new Evenement($tabEvent);
    $managerEvenement->add($evenement);
    header("Location: index.php?page=3");
    exit;
}

//Modifie un évènement
if(isset($_POST["titreModifie"])){
    $tabEvent=Array();
    $tabEvent["event_num"]=$_SESSION["numEventAModifier"];
    $tabEvent["event_titre"]=$_POST["titreModifie"];
    $date= getEnglishDate($_POST["dateModifie"]);
    $tabEvent["event_date"]=$date;
    $tabEvent["event_heure"]=$_POST["heureModifie"];
    $tabEvent["event_texte"]=$_POST["texteModifie"];
    $tabEvent["event_ville"]=$_POST["villeModifie"];
    $evenement=new Evenement($tabEvent);
    $managerEvenement->modifierEvenement($evenement);
    header("Location: index.php?page=3");
    exit;
}

//Supprime un évènement
if(isset($_POST["numEventASupprimer"])){
    $managerPersonne->deletePersonneInscrit($_POST["numEventASupprimer"]);
    $managerEvenement->deleteEvenement($_POST["numEventASupprimer"]);
    header("Location: index.php?page=3");
    exit;
}

//Ajouter une personne à un event
if(!isset($_SESSION["login"]) && isset($_POST["inscription"])){
   $tab=array();
   $tab["per_nom"]=$_POST["nomParticipant"];
   $tab["per_prenom"]=$_POST["prenomParticipant"];
   $tab["per_mail"]=$_POST["mailParticipant"];
   $personne = new Personne($tab);
   echo $personne->getPerNum();
   if(!($managerPersonne->existe($_POST["mailParticipant"]))){
     $managerPersonne->add($personne);
     $managerPersonne->ajouterUneInscription($personne->getPerNum(),$_POST["numEventInscription"]);
   }else{
     $personne = $managerPersonne->getPersonne($_POST["mailParticipant"]);
     if(!($managerPersonne->dejaInscrit($personne->getPerNum(),$_POST["numEventInscription"]))){
      $managerPersonne->ajouterUneInscription($personne->getPerNum(),$_POST["numEventInscription"]);
     }else{
         //TODO mettre en valeur ce message d'erreur
       echo "cette personne est déjà inscrite !";
     }
   }
 }
?>

<h1 class="titreVert">Evènement</h1>

<?php
//Affiche les évènements de la page Evenement
foreach ($managerEvenement->getAllEvenement() as $evenement) {
    $dateEvent=date_create($evenement->getDate());
    $heureEvent=date_create($evenement->getHeure());
    //Récupère le nom du mois en fonction de son numéro
    $mois=getMois(date_format($dateEvent, 'm'));
    //Récupère la date de l'évènement au format 23 Septembre 2016
    $date = date_format($dateEvent, 'd ') . $mois . date_format($dateEvent, ' Y');
    //Récupère l'heure de l'évènement au format 14h59
    $heure= date_format($heureEvent, 'H:i');

    //Affiche l'évènement à modifier
    if(isset($_POST["numEventAModifier"]) && $_POST["numEventAModifier"] == $evenement->getNum()){
        $_SESSION["numEventAModifier"]=$evenement->getNum();
        ?>
        <div id="formulaireAjoutEvenement">
            <form class="modifier" method="POST" action="#">
                <label>Titre de l'évènement:</label>
                <input type="text" name="titreModifie" value="<?php echo $evenement->getTitre();?>" required autofocus>
                <br>
                <label>Date de l'évènement:</label>
                <input type="text" class="datepicker" name="dateModifie" min="<?php echo date('Y-m-j'); ?>" value="<?php echo getFrenchDate($evenement->getDate());?>" required>
                <br>
                <label>Heure de l'évènement:</label>
                <input type="time" name="heureModifie" value="<?php echo $evenement->getHeure();?>" required>
                <br>
                <label>Ville de l'évènement:</label>
                <input type="text" name="villeModifie" value="<?php echo $evenement->getVille();?>" required>
                <br>
                <label>Texte:</label>
                <textarea name="texteModifie" class="texteArea" rows="8" required><?php echo $evenement->getTexte();?></textarea>
                <br>
                <input class="boutonModifierFinal" type="button" value="Modifier l'évènement">
            </form>
        </div>
        <?php
    //Sinon affiche l'évènement
    }else{?>
        <div class="divArticle">
            <article>
                <?php
                echo "<h1>" . $evenement->getTitre() . "</h1>";
                echo "<p class=\"dateEvenement\">" . "Le " . $date . "</p>";
                echo "<p class=\"detailEvenement\">" . "À partir de " . $heure . "</p>";
                echo "<p class=\"detailEvenement\">" . "À " . $evenement->getVille() . "</p>";
                echo $evenement->getTexte();

                $now = date('Y-m-d');
                $next = $evenement->getDate();

                // Pour voir si la personne peut s'inscrire ou pas. Si event passé.
                $now = new DateTime( $now );
                $now = $now->format('Ymd');
                $next = new DateTime( $next );
                $next = $next->format('Ymd');

                //Inscription d'une personne à event
                if(!isset($_SESSION["login"]) && ($next > $now)){ ?>
                    <div class="divInscription">
                        <a href="" class="lienInscrire" id="boutonInscrire<?php echo $evenement->getNum();?>">
                            <img class="imgInscrire" src="./image/icon/inscrire.png" alt="S'inscrire">
                            <span class="inscrire">S'inscrire</span>
                        </a>
                    </div>
                    <br>
                    <form id="formInscription<?php echo $evenement->getNum()?>" method="POST" action="#">
                        <label>Nom :</label>
                        <input type="text" name="nomParticipant" required><br>
                        <label>Prenom :</label>
                        <input type="text" name="prenomParticipant" required><br>
                        <label>Mail :</label>
                        <input type="email" name="mailParticipant" required>
                        <input name="numEventInscription" type="hidden" value="<?php echo $evenement->getNum(); ?>">
                        <input type="submit" name="inscription">
                    </form>
                    <?php
                    echo "<script>$(document).ready(function(){
                      $('#formInscription" . $evenement->getNum() . "').hide();
                      $('a#boutonInscrire" . $evenement->getNum() . "').click(function()
                     {
                         $('#formInscription" . $evenement->getNum() . "').toggle(400);
                         return false;
                      });
                   });</script>";
                }else if(!isset($_SESSION["login"])){ ?>
                   <div class="divInscription">
                       <img class="imgInscrire inscritGris" src="./image/icon/inscrire.png" alt="S'inscrire">
                       <span class="inscrire">S'inscrire</span>
                   </div>
                <?php
                }

                //Affiche un évènement en mode admin
                if(isset($_SESSION["login"]) && !isset($_POST["numEventAModifier"])){
                    if($managerPersonne->getNbPersonneInscrite($evenement->getNum()) > 0){?>
                        <input type="button" class="lienPersonneInscrite">

                        <label class="lblPersonneInscrite"><?php echo $managerPersonne->getNbPersonneInscrite($evenement->getNum());
                            if($managerPersonne->getNbPersonneInscrite($evenement->getNum()) > 1){
                                echo " personnes inscrites";
                            }else{
                                echo " personne inscrite";
                            }
                            ?>
                        </label>
                        <div class="divPersonneInscrite">
                            <table id="tableInscris<?php echo $evenement->getNum();?>">
                                <tr>
                                    <th>Nom</th>
                                    <th>Prenom</th>
                                    <th>Mail</th>
                                </tr>
                                <?php
                                foreach ($managerPersonne->getPersonneInscriteEvent($evenement->getNum()) as $personne){ ?>
                                    <tr>
                                        <td><?php echo $personne->getPerNom(); ?></td>
                                        <td><?php echo $personne->getPerPrenom(); ?></td>
                                        <td><?php echo $personne->getPerMail(); ?></td>
                                    </tr>
                                <?php
                                } ?>
                            </table>
                        </div>
                        <?php
                    }
                }?>
            </article>
            <?php
            if(isset($_SESSION["login"])){
                if(!isset($_POST["numEventAModifier"])){?>
                    <div class="voletGestionArticle">
                        <form class="supprimer" method="POST" action="#">
                            <input name="supprimerArticle" class="boutonSupprimer input_btn1" type="button" value="Supprimer">
                            <input class="num" name="numEventASupprimer" type="hidden" value="<?php echo $evenement->getNum(); ?>">
                        </form>
                        <form class="modifierEvent" method="POST" action="#">
                            <input name="modifierArticle" class="boutonModifier input_btn2" type="submit" value="Modifier" >
                            <input class="numModif" name="numEventAModifier" type="hidden" value="<?php echo $evenement->getNum(); ?>">
                        </form>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
<?php
    }
}

//Affiche le formulaire pour ajouter un évènement
if(isset($_SESSION["login"])){?>
    <div id="formulaireAjoutEvenement">
        <input type="button" id="boutonPlusFormulaireAjout" value="+">
        <form method="POST" action="#" id="formulaireEvenement" novalidate>
            <label>Titre de l'évènement:</label>
            <input type="text" name="titre" placeholder="Titre de l'évènement..." required>
            <br>
            <label>Date de l'évènement:</label>
            <input type="text" class="datepicker" name="date" required>
            <br>
            <label>Heure de l'évènement:</label>
            <input type="time" name="heure" value="00:00" required>
            <br>
            <label>Ville de l'évènement:</label>
            <input type="text" name="ville" placeholder="Ville..." required>
            <br>
            <label>Texte:</label>
            <textarea name="texte" class="texteArea" placeholder="Description de l'évènement..." rows="8" required></textarea>
            <br>
            <input class="bouton" type="submit" value="Ajouter l'évènement">
        </form>
    </div>
<?php
}?>
