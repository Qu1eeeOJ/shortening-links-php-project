<?php
// Check if the get parameter
if (!isset($_GET['r'])) {
    // If a person was sent here by a redirect, then we return them back
    if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location: $_SERVER[HTTP_REFERER]");
    } else {
        // If you do not know the previous page, then redirect to the main page
        header('Location: /');
    }
}

// Writing the get parameter value to a variable
$redirect_from = $_GET['r'];

// Launch applications
$app = require 'app/bootstrap/bootstrap.php';

use App\Vendor\DB\DB;

// // Getting an instance of the DB class
$db = DB::getInstance();

// We check whether there is such an abbreviated link
if ($db->queryWithPrepare('SELECT COUNT(1) FROM `links` WHERE `redirect_from` = :redirect_from', ['redirect_from' => $redirect_from])->fetch()['COUNT(1)'] == 0) {
    echo 'ERROR: No such link was found';
    return;
}

// Getting a link to redirect to
$redirect_to = $db->queryWithPrepare('SELECT `redirect_to` FROM `links` WHERE `redirect_from` = :redirect_from', ['redirect_from' => $redirect_from])->fetch()['redirect_to'];

// Performing redirects
header("Location: $redirect_to");
return;