<?php
require_once '../../vendor/autoload.php';
require_once '../../app/Libs/Utils.php';
require_once '../../app/Libs/Validator.php';

use App\Infrastructure\DAO\UserDAO;

$errors = [];
$email = '';
$password = '';

session_start();

if (isset($_SESSION['login'])) {
    session_regenerate_id(true);
    Utils::redirect('../index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = Utils::sanitize(filter_input(INPUT_POST, 'email') ?? '');
    $password = Utils::sanitize(filter_input(INPUT_POST, 'password') ?? '');
    if (!Validator::isNotBlank($email)) {
        $errors['email'] = 'メールアドレスを入力してください。';
    }
    if (!Validator::isNotBlank($password)) {
        $errors['password'] = 'パスワードを入力してください。';
    }
    if (empty($errors)) {
        $userDAO = new UserDAO();
        $user = $userDAO->findByMail($email);
        if (!is_null($user) && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['login'] = [
                'name' => $user['name'],
                'email' => $user['email'],
            ];
            Utils::redirect('../index.php');
        }
        $errors['system'] = 'メールアドレスまたはパスワードが違います。';
    }
}
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
  <div class="container">
    <h1>ログイン</h1>
    <form method="POST" novalidate>
<?php if (!empty($errors['system'])): ?>
    <div class="error"><?php echo $errors['system']; ?>
<?php endif; ?>
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
        <button type="submit">ログイン</button>
      </div>
      <div>
        <a href="./signup.php">アカウントを作る</a>
      </div>
    </form>
  </div>
</body>
</html>