<?php

// Getting a request from axios
$_POST = json_decode(file_get_contents('php://input'), true);

// We check whether the person logged in directly or sent a post request
if (!isset($_POST['url'])) {
    // If a person was sent here by a redirect, then we return them back
    if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location: $_SERVER[HTTP_REFERER]");
    } else {
    // If you do not know the previous page, then redirect to the main page
        header('Location: /');
    }
}

// Launch applications
$app = require 'app/bootstrap/bootstrap.php';

// Removing the right slash
$_POST['url'] = trim($_POST['url'], '/');

// Check if this is a link
if (!preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-A-zA0-9+&@#\/%?=~_|!:,.;]*[-A-z0-9+&@#\/%=~_|]/', $_POST['url'])) {
    echo toAxios('error', 'This is not a link', ['redirect_to' => 'This is not a link']);
    return;
}

use App\Vendor\DB\DB;
use App\Vendor\Helpers\Str;

// Getting an instance of the DB class
$db = DB::getInstance();

// We check whether there was such a link in the database
if ($db->queryWithPrepare('SELECT COUNT(1) FROM `links` WHERE `redirect_to` = :url', ['url' => $_POST['url']])->fetch()['COUNT(1)'] != 0) {
    // Return the link, if it was already created
    $url_from = $db->queryWithPrepare('SELECT `redirect_from` FROM `links` WHERE `redirect_to` = :url', ['url' => $_POST['url']])->fetch();
    echo toAxios('error', 'This entry already exists', $url_from);
    return;
}

// Preparing data for insertion into the database
$params = [
    'url_to' => $_POST['url'],
    'url_from' => Str::rand()
];

// Creating a short link
$db->queryWithPrepare('INSERT INTO `links` (`redirect_to`, `redirect_from`) VALUES (:url_to, :url_from)', $params);

// Returning a short link
echo toAxios('success', 'The link was created successfully', ['redirect_from' => generateUrl($params['url_from'])]);
return;