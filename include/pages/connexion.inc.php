<?php
require 'recaptchalib.php';
//On met les clé API pour le capcha
$siteKey = '6Ld85BoUAAAAAEhy7F5X9ZsLvY2u-tQ_JhD9pWsb'; //clé publique
$secret = '6Ld85BoUAAAAANYhCWyYpebDKyxI2yNYLyoJxQJx'; //clé privée

// Paramètre renvoyé par le recaptcha
$response = $_POST['g-recaptcha-response'];

// On récupère l'IP de l'utilisateur
$remoteip = $_SERVER['REMOTE_ADDR'];

$api_url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $response . "&remoteip=" . $remoteip ;

$decode = json_decode(file_get_contents($api_url), true);

if ($decode['success'] == true) {
    if(isset($_POST["login"])){
        $login = $_POST["login"];
        $password = $_POST["password"];
        if($managerAdministrateur->checkLoginPassword($login, $password)){
            $_SESSION["login"] = $login;
            header("Location: index.php");
            exit;
        }
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
        echo "<p class=\"messageErreurLoginPassword\">L'identifiant ou le mot de passe est incorrect</p>";
    }
    ?>
    <div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
    <input class="bouton" type="submit" value="Connexion">
</form>
