<?php
//A UTILISER POUR PROTEGER DES PAGES CONTRE LA MANIPULATION DES URL SANS ETRE CONNECTES.
function check_login()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user'])) {
        header('Location: ' . BASE_URL . '/login');
        exit();
    }
}

function check_admin()
{

    check_login();


    if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
        header('Location: ' . BASE_URL . '/home');
        exit();
    }
}