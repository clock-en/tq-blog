<?php
require_once '../../vendor/autoload.php';

use App\UseCase\UseCaseInput\SigninInput;
use App\UseCase\UseCaseInteractor\SigninInteractor;
use App\Infrastructure\Dao\MessagesSessionDao;
use App\Infrastructure\Dao\LoginSessionDao;
use App\Exception\InputErrorExeception;
use App\Utils\Response;
use App\Utils\Validator;

$errors = [];
$email = '';
$password = '';

session_start();
$messagesDao = new MessagesSessionDao();
$messages = $messagesDao->getMessages();
$loginDao = new LoginSessionDao();
if (!is_null($loginDao->getLoginUser())) {
    Response::redirect('../index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $email = Validator::sanitize(filter_input(INPUT_POST, 'email') ?? '');
        $password = Validator::sanitize(
            filter_input(INPUT_POST, 'password') ?? ''
        );
        if (!Validator::isNotBlank($email)) {
            $errors['email'] = 'メールアドレスを入力してください。';
        }
        if (!Validator::isNotBlank($password)) {
            $errors['password'] = 'パスワードを入力してください。';
        }
        if (!empty($errors)) {
            throw (new InputErrorExeception(
                '入力された値に誤りがあります',
                400
            ))->setErrors($errors);
        }
        $input = new SigninInput($email, $password);
        $usecase = new SigninInteractor($input);
        $output = $usecase->handle();
        if (!$output->isSuccess()) {
            throw (new InputErrorExeception(
                '入力された値に誤りがあります',
                400
            ))->setErrors(['system' => $output->getMessage()]);
        }
        $messagesDao->setMessage($output->getMessage());
        Response::redirect('../index.php');
    } catch (InputErrorExeception $e) {
        $errors = array_merge($errors, $e->getErrors());
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
<?php require_once '../includes/header.php'; ?>
  <div class="container">
    <h1>ログイン</h1>
<?php if (!is_null($messages)): ?>
    <?php foreach ($messages as $m): ?>
    <div class="success"><?php echo $m; ?></div>
    <?php endforeach; ?>
<?php endif; ?>

    <form method="POST" novalidate>
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