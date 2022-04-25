<?php
require_once '../../vendor/autoload.php';

use App\UseCase\SignUp\SignUpInput;
use App\UseCase\SignUp\SignUpInteractor;
use App\Exception\InputErrorExeception;
use App\Utils\Session;
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
    $session = Session::getInstance();
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

    $input = new SignUpInput($name, $email, $password);
    $usecase = new SignUpInteractor($input);
    $output = $usecase->handle();

    if (!$output->isSuccess()) {
        throw (new InputErrorExeception(
            '入力された値に誤りがあります',
            400
        ))->setErrors(['email' => $output->getMessage()]);
    }

    $session->appendMessage($output->getMessage());
    Response::redirect('./signin.php');
} catch (InputErrorExeception $e) {
    $formData = compact('name', 'email', 'password', 'passwordConfirm');
    $session->setFormInputs($formData);

    $errors = $e->getErrors();
    foreach ($errors as $key => $error) {
        $session->appendError($key, $error);
    }

    Response::redirect('./signup.php');
}
