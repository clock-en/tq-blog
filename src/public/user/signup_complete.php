<?php
require_once '../../vendor/autoload.php';

use App\UseCase\UseCaseInput\SignupInput;
use App\UseCase\UseCaseInteractor\SignupInteractor;
use App\Infrastructure\Dao\MessagesSessionDao;
use App\Infrastructure\Dao\FormDataSessionDao;
use App\Infrastructure\Dao\ErrorsSessionDao;
use App\Exception\InputErrorExeception;
use App\Utils\Response;
use App\Utils\Validator;

// GETでのアクセス防止
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::redirect('./signup.php');
}

$errors = [];
$name = Validator::sanitize(filter_input(INPUT_POST, 'name') ?? '');
$email = Validator::sanitize(filter_input(INPUT_POST, 'email') ?? '');
$password = Validator::sanitize(filter_input(INPUT_POST, 'password') ?? '');
$passwordConfirm = Validator::sanitize(
    filter_input(INPUT_POST, 'passwordConfirm') ?? ''
);

try {
    session_start();
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

    $messagesDao = new MessagesSessionDao();
    $messagesDao->setMessage($output->getMessage());
    Response::redirect('./signin.php');
} catch (InputErrorExeception $e) {
    $formDataDao = new FormDataSessionDao();
    $errorsDao = new ErrorsSessionDao();

    $formData = compact('name', 'email', 'password', 'passwordConfirm');
    $formDataDao->setFormData($formData);

    $errors = array_merge($errors, $e->getErrors());
    $errorsDao->setErrors($errors);

    Response::redirect('./signup.php');
}
