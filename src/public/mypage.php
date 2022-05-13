<?php
require_once '../vendor/autoload.php';

use App\Utils\Session;
use App\Utils\Response;

$session = Session::getInstance();
$user = $session->getUser();
if (is_null($user)) {
    Response::redirect('./user/signin.php');
}

$messages = $session->popMessages();
?><!doctype html>
<html>
<head>
<meta charset="UTF-8"> 
<meta http-equiv="content-language" content="ja"> 
<meta name="description" content="マイページ"> 
<title>マイページ</title>
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
WIP
<?php foreach ($messages as $m): ?>
    <div class="success"><?php echo $m; ?></div>
<?php endforeach; ?>
<?php echo "<p>{$user['name']}さんのマイページ。</p>"; ?>
</body>
</html>