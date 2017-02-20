<?php
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');
error_reporting(E_ALL);

require_once 'classes/BS/Common/Autoload.php';
use BS\Common\Router;

session_start();
if (!empty($_COOKIE['sid'])) {
    session_id($_COOKIE['sid']);
}

echo (new Router())->go();