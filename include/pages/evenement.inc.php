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
     echo "cette personne n'existe pas";
     $managerPersonne->add($personne);
     $managerPersonne->ajouterUneInscription($personne->getPerNum(),$_POST["numEventInscription"]);
   }else{
     echo "cette personne existe";
     $personne = $managerPersonne->getPersonne($_POST["mailParticipant"]);
     if(!($managerPersonne->dejaInscrit($personne->getPerNum(),$_POST["numEventInscription"]))){
      $managerPersonne->ajouterUneInscription($personne->getPerNum(),$_POST["numEventInscription"]);
     }else{
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

    if(isset($_POST["modifierEvent"]) && $_POST["numEventAModifier"]==$evenement->getNum()){
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
    }else{?>
        <article>
            <?php
            echo "<h1>" . $evenement->getTitre() . "</h1>";
            echo "<p class=\"dateEvenement\">" . "Le " . $date . "</p>";
            echo "<p class=\"detailEvenement\">" . "À partir de " . $heure . "</p>";
            echo "<p class=\"detailEvenement\">" . "À " . $evenement->getVille() . "</p>";
            echo "<p>" . $evenement->getTexte() . "</p>";

            $now = date('Y-m-d');
            $next = $evenement->getDate();

            // test
            $now = new DateTime( $now );
            $now = $now->format('Ymd');
            $next = new DateTime( $next );
            $next = $next->format('Ymd');

            if(!isset($_SESSION["login"]) && ($next > $now)){ ?>
              <a href="" id="boutonInscrire<?php echo $evenement->getNum();?>">s'inscrire</a>
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
       }

        }
        if(isset($_SESSION["login"])){ ?>
          <a href="" id="boutonInscrire<?php echo $evenement->getNum();?>">Voir les personnes inscrite</a><br>
          <label>Il y a <?php echo $managerPersonne->getNbPersonneInscrite($evenement->getNum()); ?> personnes inscrites.</label>
          <?php
          if($managerPersonne->getNbPersonneInscrite($evenement->getNum()) > 0){
          ?>
          <table id="tableInscris<?php echo $evenement->getNum();?>">
            <tr>
              <th>Prenom</th>
              <th>Nom</th>
              <th>Mail</th>
            </tr>
          <?php foreach ($managerPersonne->getPersonneInscriteEvent($evenement->getNum()) as $personne){ ?>
              <tr>
                <td><?php echo $personne->getPerPrenom(); ?></td>
                <td><?php echo $personne->getPerNom(); ?></td>
                <td><?php echo $personne->getPerMail(); ?></td>
              </tr>

        <?php  } ?>
        </table>
      <?php
     echo "<script>$(document).ready(function(){
       $('#tableInscris" . $evenement->getNum() . "').hide();
       $('a#boutonInscrire" . $evenement->getNum() . "').click(function()
       {
          $('#tableInscris" . $evenement->getNum() . "').toggle(400);
          return false;
       });
      });</script>";
      }
    }
      ?>
          </article>
    <?php
    }

    if(isset($_SESSION["login"])){
        if(!isset($_POST["modifierEvent"]) || (isset($_POST["modifierEvent"]) && $_POST["numEventAModifier"]!=$evenement->getNum())){?>
            <div class="voletGestionArticle">
                <form class="supprimer" method="POST" action="#">
                  <input name="supprimerEvent" class="boutonSupprimer" type="button" value="X">
                    <input class="num" name="numEventASupprimer" type="hidden" value="<?php echo $evenement->getNum(); ?>">
                </form>
                <form class="modifierEvent" method="POST" action="#">
                    <input name="modifierEvent" class="boutonModifier" type="submit" value="M">
                    <input class="numModif" name="numEventAModifier" type="hidden" value="<?php echo $evenement->getNum(); ?>">
                </form>
            </div>
        <?php
        }
    }

if(isset($_SESSION["login"])){?>
    <div id="formulaireAjoutEvenement">
        <form method="POST" action="#" novalidate>
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
