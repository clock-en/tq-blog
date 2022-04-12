<?php
require_once '../vendor/autoload.php';

use App\Infrastructure\Dao\LoginSessionDao;

session_start();
$loginDao = new LoginSessionDao();
$user = $loginDao->getLoginUser();
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
<?php require_once './includes/header.php'; ?>
<?php
echo 'Welcome TECH QUEST!';
if (!is_null($user)) {
    echo "<p>{$user['name']}さん。こんにちは。</p>";
} else {
    echo '<p><a href="/user/signin.php">ログイン</p>';
}
?>
</body>
</html>