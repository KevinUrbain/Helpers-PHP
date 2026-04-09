<?php
declare(strict_types=1);
/**
 * Traite une chaîne de caractères pour vérifier la sécurité d'un mot de passe. Vérifie si plus de 8 caractères, si présence d'une majuscule et d'un chiffre.
 *
 * @param string $password Le mot de passe.
 * @return true ou array $errors
 */
function verifyPassword(string $password): bool|array
{
    $errors = [];
    $is_valid = true;

    if (strlen($password) < 8) {
        $errors['err_length'] = 'Le mot de passe doit faire au moins 8 caractères';
        $is_valid = false;
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors['err_upper'] = 'Le mot de passe doit contenir au moins une majuscule';
        $is_valid = false;
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors['err_number'] = 'Le mot de passe doit contenir au moins un chiffre';
        $is_valid = false;
    }
    if (empty($errors)) {
        return $is_valid;
    }

    return $errors;
}

$password = verifyPassword('quA32EUQ');

var_dump($password);