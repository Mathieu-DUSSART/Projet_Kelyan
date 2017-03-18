<?php
if(isset($_POST["login"])){
    $login = $_POST["login"];
    $password = $_POST["password"];
    if($managerAdministrateur->checkLoginPassword($login, $password)){
        $_SESSION["login"] = $login;
        header("Location: index.php");
        exit;
    }
}
?>

<h1>Se connecter</h1>

<form id="formConnexion" method="POST" action="#" autocomplete="off">
    <label>Login :</label>
    <input  type="text" name="login" required>

    <label>Mot de passe :</label>
    <input  type="password" name="password" required>
    <?php
    if(isset($login) && isset($password) && !$managerAdministrateur->checkLoginPassword($login, $password)){
        echo "<p class=\"messageErreurLoginPassword\">L'identifiant ou le mot de passe est incorrecte</p>";
    }?>

    <input class="bouton" type="submit" value="Connexion">
</form>
