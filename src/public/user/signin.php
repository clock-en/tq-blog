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

    <form method="POST" action="./signin_complete.php" novalidate>
<?php if (!empty($errors['system'])): ?>
    <div class="error"><?php echo $errors['system']; ?></div>
<?php endif; ?>
    <div>
      <input type="email" name="email" placeholder="メールアドレス" maxlength="255" value="<?php echo $email; ?>">
<?php if (!empty($errors['email'])): ?>
        <div class="error"><?php echo $errors['email']; ?></div>
<?php endif; ?>
      </div>
      <div>
        <input type="password" name="password" placeholder="Password" maxlength="20" value="<?php echo $password; ?>">
<?php if (!empty($errors['password'])): ?>
        <div class="error"><?php echo $errors['password']; ?></div>
<?php endif; ?>
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