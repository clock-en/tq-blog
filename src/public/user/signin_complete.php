<?php
require_once '../../vendor/autoload.php';

use App\UseCase\SignIn\SignInInput;
use App\UseCase\SignIn\SignInInteractor;
use App\Exception\InputErrorExeception;
use App\Utils\Session;
use App\Utils\Response;
use App\Utils\Validator;

// GETでのアクセス防止
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::redirect('./signin.php');
}

$errors = [];
$email = Validator::sanitize(filter_input(INPUT_POST, 'email') ?? '');
$password = Validator::sanitize(filter_input(INPUT_POST, 'password') ?? '');

try {
    $session = Session::getInstance();
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

    $input = new SignInInput($email, $password);
    $usecase = new SignInInteractor($input);
    $output = $usecase->handle();

    if (!$output->isSuccess()) {
        throw (new InputErrorExeception(
            '入力された値に誤りがあります',
            400
        ))->setErrors(['system' => $output->getMessage()]);
    }

    $session->appendMessage($output->getMessage());
    Response::redirect('../index.php');
} catch (InputErrorExeception $e) {
    $formData = compact('email', 'password');
    $session->setFormInputs($formData);

    $errors = $e->getErrors();
    foreach ($errors as $key => $error) {
        $session->appendError($key, $error);
    }

    Response::redirect('./signin.php');
}
