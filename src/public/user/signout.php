<?php
require_once '../../vendor/autoload.php';

use App\Utils\Response;
use App\Utils\Session;

// GETでのアクセス防止
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::redirect('../index.php');
}

$session = Session::getInstance();
$session->destroy();
Response::redirect('./signin.php');
