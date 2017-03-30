


<h1>Modifier le mot de passe</h1>

<form id="formConnexion" method="POST" action="#" autocomplete="off">

    <label>Mot de passe actuel :</label>
    <input  type="password" name="password" required>

    <label>Nouveau Mot de passe :</label>
    <input type="password" name="password" required>

    <label>Confirmation du nouveau mot de passe :</label>
    <input type="password" name="password" required>

    <?php
    if(isset($password) && !$managerAdministrateur->checkLoginPassword($login, $password)){
        echo "<p class=\"messageErreurLoginPassword\">le mot de passe est incorrect !</p>";
    }?>

    <input class="bouton" type="submit" value="Connexion">
</form>
