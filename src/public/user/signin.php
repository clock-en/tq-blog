<?php
require_once '../../vendor/autoload.php';

use App\Infrastructure\Dao\UserSqlDao;
use App\Infrastructure\Dao\LoginSessionDao;
use App\Utils\Response;
use App\Utils\Validator;

$errors = [];
$email = '';
$password = '';

session_start();

$loginDao = new LoginSessionDao();
if (!is_null($loginDao->getLoginUser())) {
    Response::redirect('../index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = Validator::sanitize(filter_input(INPUT_POST, 'email') ?? '');
    $password = Validator::sanitize(filter_input(INPUT_POST, 'password') ?? '');
    if (!Validator::isNotBlank($email)) {
        $errors['email'] = 'メールアドレスを入力してください。';
    }
    if (!Validator::isNotBlank($password)) {
        $errors['password'] = 'パスワードを入力してください。';
    }
    if (empty($errors)) {
        $userDAO = new UserSqlDao();
        $user = $userDAO->findByMail($email);
        if (!is_null($user) && password_verify($password, $user['password'])) {
            $loginDao->getLoginUser($user['name'], $user['email']);
            Response::redirect('../index.php');
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
      <input type="email" name="email" placeholder="メールアドレス" maxlength="255" value="<?php echo $email; ?>">
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