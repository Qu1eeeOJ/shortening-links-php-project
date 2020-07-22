<?php

return [

    /**
     * Database Connections
     *
     * This project uses PHP PDO
     * Some settings for configuring mysql are listed below
     */

    'host' => 'localhost',
    'db' => 'shortlinks',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8mb4',
    'opt' => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false
    ]

];