<?php
require_once '../../vendor/autoload.php';

use App\Utils\Session;

$session = Session::getInstance();
$formInputs = $session->popFormInputs();
$errors = $session->popErrors();

$name = $formInputs['name'] ?? '';
$email = $formInputs['email'] ?? '';
$password = $formInputs['password'] ?? '';
$passwordConfirm = $formInputs['passwordConfirm'] ?? '';
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
<?php require_once '../includes/header.php'; ?>
  <div class="container">
    <h1>会員登録</h1>
<?php foreach ($errors as $e): ?>
    <div class="error"><?php echo $e; ?></div>
<?php endforeach; ?>
    <form method="POST" action="./signup_complete.php" novalidate>
      <div>
        <input name="name" placeholder="ユーザー名" maxlength="255" value="<?php echo $name; ?>">
      </div>
      <div>
        <input name="email" placeholder="メールアドレス" maxlength="255" value="<?php echo $email; ?>">
      </div>
      <div>
        <input type="password" name="password" placeholder="Password" maxlength="20" value="<?php echo $password; ?>">
      </div>
      <div>
        <input type="password" name="passwordConfirm" placeholder="Password確認" maxlength="20" value="<?php echo $passwordConfirm; ?>">
      </div>
      <div>
        <button type="submit">アカウント作成</button>
      </div>
      <div>
        <a href="./signin.php">ログイン画面へ</a>
      </div>
    </form>
  </div>
</body>
</html>