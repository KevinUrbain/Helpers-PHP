<?php
declare(strict_types=1);

function generatePassword(int $length): string
{

    if ($length <= 0) {
        return "La longueur du mot de passe doit être supérieure à 0";
    }

    $password = '';
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*().-_;';
    $maxIndex = strlen($chars) - 1;

    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, $maxIndex)];
    }

    return $password;

}


//Utilisation
$password = generatePassword(12);
echo $password;