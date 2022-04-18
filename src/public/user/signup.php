<?php
require_once '../../vendor/autoload.php';

use App\UseCase\UseCaseInput\SignupInput;
use App\UseCase\UseCaseInteractor\SignupInteractor;
use App\Infrastructure\Dao\MessagesSessionDao;
use App\Exception\InputErrorExeception;
use App\Utils\Response;
use App\Utils\Validator;

$errors = [];
$name = '';
$email = '';
$password = '';
$passwordConfirm = '';

session_start();
$messagesDao = new MessagesSessionDao();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = Validator::sanitize(filter_input(INPUT_POST, 'name') ?? '');
        $email = Validator::sanitize(filter_input(INPUT_POST, 'email') ?? '');
        $password = Validator::sanitize(
            filter_input(INPUT_POST, 'password') ?? ''
        );
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
        if (!empty($errors)) {
            throw (new InputErrorExeception(
                '入力された値に誤りがあります',
                400
            ))->setErrors($errors);
        }

        $input = new SignupInput($name, $email, $password);
        $usecase = new SignupInteractor($input);
        $output = $usecase->handle();

        if (!$output->isSuccess()) {
            throw (new InputErrorExeception(
                '入力された値に誤りがあります',
                400
            ))->setErrors(['email' => $output->getMessage()]);
        }
        $messagesDao->setMessage($output->getMessage());
        Response::redirect('./signin.php');
    } catch (InputErrorExeception $e) {
        $errors = array_merge($errors, $e->getErrors());
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
<?php require_once '../includes/header.php'; ?>
  <div class="container">
    <h1>会員登録</h1>
    <form method="POST" action="./signup.php" novalidate>
      <div>
        <input name="name" placeholder="ユーザー名" maxlength="255" value="<?php echo $name; ?>">
<?php if (!empty($errors['name'])): ?>
        <div class="error"><?php echo $errors['name']; ?></div>
<?php endif; ?>
      </div>
      <div>
        <input name="email" placeholder="メールアドレス" maxlength="255" value="<?php echo $email; ?>">
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
        <input type="password" name="password_confirm" placeholder="Password確認" maxlength="20" value="<?php echo $passwordConfirm; ?>">
<?php if (!empty($errors['passwordConfirm'])): ?>
        <div class="error"><?php echo $errors['passwordConfirm']; ?></div>
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