<h1>Se connecter</h1>

<form method="POST" action="#" autocomplete="off">
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
    $login = $_POST["login"];
    $password = $_POST["password"];
    if($managerAdministrateur->checkLoginPassword($login, $password)){
        $_SESSION["login"] = $login;
        header("Location: index.php");
        exit;
    }else{
        echo "Incorrecte";
    }
}
?>
