<?php
require_once '../../vendor/autoload.php';

use App\UseCase\UseCaseInput\SigninInput;
use App\UseCase\UseCaseInteractor\SigninInteractor;
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

    $input = new SigninInput($email, $password);
    $usecase = new SigninInteractor($input);
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
