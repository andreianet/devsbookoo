<?php

require 'config.php';
require 'models/Auth.php';

$name = filter_input(INPUT_POST,'name');
$email = filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST,'password');
$birthDate = filter_input(INPUT_POST,'birthdate'); //00/00/0000


if ($name && $email && $password && $birthDate) {
    
    $auth = new Auth($pdo, $base);
    /**
     * Verificar mask birthdate
     */
    $birthdate = explode("/",$birthdate);
    if ($count($birthdate) != 3) {
        $_SESSION['flash'] = 'Data de nascimento inválida.';
        header("Location : ".$base."/signup.php");
        exit;
    }
    /**
     * Verificar o Data preenchida
     */
    $birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];
    if (strtotime($birthdate) === false) {
        $$_SESSION['flash'] = 'Data de nascimento inválida.';
        header("Location : ".$base."/signup.php");
        exit;
    }

    /**
     * E-mail exists
     */
    if ($auth->emailExists === false) {
        $auth->registerUser($name, $email, $password, $birthdate);
        header("Location : ".$base);

    }else{
        $_SESSION['flash'] = 'E-mail já cadastrado.';
        header("Location : ".$base."/signup.php"); 
        exit;
    }
    
}

$_SESSION['flash'] = 'Campos não enviados!.';
header("Location : ".$base."/login.php");
exit;
?>