<?php
require_once '../../vendor/autoload.php';

use App\Infrastructure\Dao\UserDao;
use App\Utils\Response;
use App\Utils\Validator;

$errors = [];
$name = '';
$email = '';
$password = '';
$passwordConfirm = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = Validator::sanitize(filter_input(INPUT_POST, 'name') ?? '');
    $email = Validator::sanitize(filter_input(INPUT_POST, 'email') ?? '');
    $password = Validator::sanitize(filter_input(INPUT_POST, 'password') ?? '');
    $passwordConfirm = Validator::sanitize(
        filter_input(INPUT_POST, 'password_confirm') ?? ''
    );
    if (!Validator::isNotBlank($name)) {
        $errors['name'] = 'ユーザー名を入力してください。';
    }
    if (!Validator::isNotBlank($email)) {
        $errors['email'] = 'メールアドレスを入力してください。';
    }
    if (!Validator::isNotBlank($password)) {
        $errors['password'] = 'パスワードを入力してください。';
    } elseif (!Validator::isMatch($password, $passwordConfirm)) {
        $errors['passwordConfirm'] = 'パスワードが一致しません。';
    }

    if (empty($errors)) {
        $userDAO = new UserDao();
        $user = $userDAO->findByMail($email);
        if (is_null($user)) {
            $userDAO->create($name, $email, $password);
            Response::redirect('./signin.php');
        }
        $errors['passwordConfirm'] =
            '入力したメールアドレスは既に入力済みです。';
    }
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
  <div class="container">
    <h1>会員登録</h1>
    <form method="POST" action="./signup.php" novalidate>
      <div>
        <input name="name" placeholder="ユーザー名" maxlength="255" value="<?php echo $name; ?>">
<?php if (!empty($errors['name'])): ?>
        <div class="error"><?php echo $errors['name']; ?>
<?php endif; ?>
      </div>
      <div>
        <input name="email" placeholder="メールアドレス" maxlength="255" value="<?php echo $email; ?>">
<?php if (!empty($errors['email'])): ?>
        <div class="error"><?php echo $errors['email']; ?>
<?php endif; ?>
      </div>
      <div>
        <input type="password" name="password" placeholder="Password" maxlength="20" value="<?php echo $password; ?>">
<?php if (!empty($errors['password'])): ?>
        <div class="error"><?php echo $errors['password']; ?>
<?php endif; ?>
      </div>
      <div>
        <input type="password" name="password_confirm" placeholder="Password確認" maxlength="20" value="<?php echo $passwordConfirm; ?>">
<?php if (!empty($errors['passwordConfirm'])): ?>
        <div class="error"><?php echo $errors['passwordConfirm']; ?>
<?php endif; ?>
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