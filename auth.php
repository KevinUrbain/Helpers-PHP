<?php
declare(strict_types=1);

/**
 * Vérification de l'existence d'une session $_SESSION['user']
 * 
 * Il faut préciser l'URL pour rediriger l'utilisateur. L'utilisation de constantes propres est recommandé.
 * @return void
 */
function check_login($url = ''): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user'])) {
        header('Location: ' . $url . '/login');
        exit();
    }
}

/**
 * Vérification de l'existence d'une session $_SESSION['user']['role'] et quelle est égale à 'admin'
 * 
 * Il faut préciser l'URL pour rediriger l'utilisateur. L'utilisation de constantes propres est recommandé.
 * Cette fonction est dépendante de check_login()
 * @return void
 */
function check_admin($url = ''): void
{
    check_login();

    if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
        header('Location: ' . $url . '/home');
        exit();
    }
}