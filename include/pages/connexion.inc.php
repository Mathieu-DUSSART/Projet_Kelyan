<h1>Se connecter</h1>

<form method="POST" action="#">
    <label>Login :</label>
    <input  type="text" name="login" required>
    <br>
    <label>Mot de passe :</label>
    <input  type="password" name="password" required>
    <br>
    <input class="bouton" type="submit" value="Connexion">
</form>

<?php
if(isset($_POST["login"])){
    if($managerAdministrateur->checkLoginPassword("Admin1", "test")){
        echo "Correcte";
    }else{
        echo "Incorrecte";
    }
}
?>
