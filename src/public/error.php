<?php
require_once '../vendor/autoload.php';

use App\Utils\Session;

$session = Session::getInstance();
$errors = $session->popErrors();
$status = http_response_code();
?><!doctype html>
<html>
<head>
<meta charset="UTF-8"> 
<meta http-equiv="content-language" content="ja"> 
<meta name="description" content="<?php echo "$status: $errors[0]"; ?>"> 
<title><?php echo "$status: $errors[0]"; ?></title>
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<?php require_once './includes/header.php'; ?>
  <div class="container container--left">
    <h1><?php echo "$status: $errors[0]"; ?></h1>
  </div>
</body>
</html>