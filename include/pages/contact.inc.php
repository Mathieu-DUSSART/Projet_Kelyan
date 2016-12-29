<h1 class="titreBleu">Nous contacter</h1>
<form id="formContact" method="POST" action="traitement_formulaire.php">
    <label>Nom:</label>
    <input  type="text" name="nomContact" required>
    <br>
    <label>Email:</label>
    <input  type="text" name="mailContact" required>
    <br>
    <label>Sujet:</label>
    <input  type="text" name="sujetContact" required>
    <br>
    <label>Message:</label>
    <textarea name="messageContact" rows="8" cols="45" placeholder="Écrivez votre message ici..." required></textarea>
    <br>
    <input name="envoi" type="submit" value="Envoyer">
</form>

<h1>Nos partenaires</h1>

<?php
//Affiche les logos des partenaires
foreach ($managerImage->getAllImage("/projet/image/partenaire/") as $image) {
    echo "<a href=\"" . $image->getLien() . "\"><img class=\"imgPartenaire\" src=\"" . $image->getSrc() . $image->getNom() . "\"alt=\"\"></a>";
}
?>
