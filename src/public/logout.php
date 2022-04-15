<?php
require_once '../vendor/autoload.php';

use App\Utils\Response;

// GETでのアクセス防止
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::redirect('./index.php');
}

session_start();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}
session_destroy();
Response::redirect('./user/signin.php');
