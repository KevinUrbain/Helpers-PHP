<?php

function log_errorException(Throwable $e, $logFile = ROOT . '/log/error_log.txt')
{
    $message = date('Y-m-d H:i:s') . ' : ' . $e->getMessage() . ', errorCode=' . $e->getCode() . "\n";
    error_log($message, 3, $logFile);
}

