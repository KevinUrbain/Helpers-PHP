<?php
declare(strict_types=1);

/**
 * Gestionnaire complet d'erreurs et d'exceptions
 * @param string $environment 'development' ou 'prod'
 * @param string $logDir      Dossier pour les logs (créé automatiquement)
 * @param string $timeZone  Par défaut initialisé à 'Europe/Brussels'
 */
function errorManager(string $environment = 'development', string $logDir = "logs", string $timeZone = 'Europe/Brussels'): void
{
    date_default_timezone_set($timeZone);

    if (!file_exists($logDir)) {
        mkdir($logDir, 0755, true);
    }
    $logFile = $logDir . "/logs.log";

    $log = function (string $message) use ($logFile) {
        $timestamp = date('Y-m-d H:i:s');
        file_put_contents($logFile, "[$timestamp] $message" . PHP_EOL, FILE_APPEND);
    };

    set_error_handler(function (int $errno, string $errstr, string $errfile, int $errline) use ($environment, $log) {
        $type = match ($errno) {
            E_NOTICE, E_USER_NOTICE => 'Notice',
            E_WARNING, E_USER_WARNING => 'Warning',
            E_ERROR, E_USER_ERROR => 'Erreur',
            E_USER_DEPRECATED => 'Déprécié',
            default => 'Autre',
        };

        $color = match ($type) {
            'Notice' => '#cce5ff',
            'Warning' => '#f8d7da',
            'Erreur' => '#f5c6cb',
            'Déprécié' => '#ffeeba',
            default => '#e2e3e5',
        };

        if ($environment === 'development') {
            echo "<div style='background:$color;color:#000;padding:15px;margin:10px;border:1px solid #ccc;border-radius:5px;'>";
            echo "<strong>Type d'erreur <u>$type</u> :</strong> " . htmlspecialchars($errstr, ENT_QUOTES, 'UTF-8') . "<br>";
            echo "<strong>Fichier :</strong> " . htmlspecialchars($errfile, ENT_QUOTES, 'UTF-8') . "<br>";
            echo "<strong>Ligne :</strong> $errline";
            echo "</div>";
        }

        $log("[$type] $errstr in $errfile line $errline");

        return true; // empêche le comportement PHP par défaut
    });

    set_exception_handler(function (Throwable $exception) use ($environment, $log) {
        $log("[Exception] " . $exception->getMessage() . " in " . $exception->getFile() . " line " . $exception->getLine());

        if ($environment === 'development') {
            echo "<div style='background:#fff3cd;color:#856404;padding:15px;margin:10px;border:1px solid #ffeeba;border-radius:5px;'>";
            echo "<strong>Type d'erreur <u>Exception</u> :</strong> " . htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
            echo "<strong>Fichier :</strong> " . htmlspecialchars($exception->getFile(), ENT_QUOTES, 'UTF-8') . "<br>";
            echo "<strong>Ligne :</strong> " . $exception->getLine() . "<br>";
            echo "<strong>Trace :</strong> " . $exception->getTraceAsString();
            echo "</div>";
        }
    });

    register_shutdown_function(function () use ($environment, $log) {
        $error = error_get_last();
        if ($error !== null) {
            $log("[Erreur fatale] " . $error['message'] . " in " . $error['file'] . " line " . $error['line']);

            if ($environment === 'development') {
                echo "<div style='background:#d1ecf1;color:#0c5460;padding:15px;margin:10px;border:1px solid #bee5eb;border-radius:5px;'>";
                echo "<strong>Erreur fatale :</strong> [" . $error['type'] . "] " . htmlspecialchars($error['message'], ENT_QUOTES, 'UTF-8') . "<br>";
                echo "<strong>Fichier :</strong> " . htmlspecialchars($error['file'], ENT_QUOTES, 'UTF-8') . "<br>";
                echo "<strong>Ligne :</strong> " . $error['line'];
                echo "</div>";
            }
        }
    });

    if ($environment === 'development') {
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    } else {
        error_reporting(0);
        ini_set("display_errors", 0);
    }
}

//=======================================================
// Utilisation de errorManager()
//=======================================================

// Exemple d'utilisation

// Active le gestionnaire d'erreurs
errorManager();

// Erreurs à tester
trigger_error("Ceci est une notice", E_USER_NOTICE);
trigger_error("Ceci est un warning", E_USER_WARNING);

// Exception volontaire
throw new Exception("Ceci est une exception volontaire");

// Pour une erreur critique (E_USER_ERROR remplacée par exception)
throw new ErrorException("Erreur critique remplacée par exception");