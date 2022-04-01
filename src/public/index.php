<?php
$user = null;
// TODO: PHPSESSIDにsecure属性とhttpOnly属性をセットしたい
session_start();
if (isset($_SESSION['login'])) {
    $user = $_SESSION['login'];
}
?><!doctype html>
<html>
<head>
<meta charset="UTF-8"> 
<meta http-equiv="content-language" content="ja"> 
<meta name="description" content="会員登録"> 
<title>会員登録</title>
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<?php
echo 'Welcome TECH QUEST!';
if (!is_null($user)) {
    echo "<p>{$user['name']}さん。こんにちは。";
}
?>
</body>
</html>