<?php
require_once '../../vendor/autoload.php';

use App\Utils\Session;
use App\Utils\Response;

$session = Session::getInstance();

$formInputs = $session->popFormInputs();
$errors = $session->popErrors();
$messages = $session->popMessages();

if ($session->existsUser()) {
    Response::redirect('../index.php');
}

$email = $formInputs['email'] ?? '';
$password = $formInputs['password'] ?? '';
?><!doctype html>
<html>
<head>
<meta charset="UTF-8"> 
<meta http-equiv="content-language" content="ja"> 
<meta name="description" content="ログインフォーム"> 
<title>サインイン</title>
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<?php require_once '../includes/header.php'; ?>
  <div class="container">
    <h1>ログイン</h1>
<?php foreach ($messages as $m): ?>
    <div class="success"><?php echo $m; ?></div>
<?php endforeach; ?>
<?php foreach ($errors as $e): ?>
    <div class="error"><?php echo $e; ?></div>
<?php endforeach; ?>

    <form method="POST" action="./signin_complete.php" novalidate>
      <div>
        <input type="email" name="email" placeholder="メールアドレス" maxlength="255" value="<?php echo $email; ?>">
      </div>
      <div>
        <input type="password" name="password" placeholder="Password" maxlength="20" value="<?php echo $password; ?>">
      </div>
      <div>
        <button type="submit">ログイン</button>
      </div>
      <div>
        <a href="./signup.php">アカウントを作る</a>
      </div>
    </form>
  </div>
</body>
</html>