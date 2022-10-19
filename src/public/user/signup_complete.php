<?php
require_once '../../vendor/autoload.php';

use App\Adapter\Presenter\SignUpPresenter;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\InputPassword;
use App\UseCase\SignUp\SignUpInput;
use App\UseCase\SignUp\SignUpInteractor;
use App\Utils\Session;
use App\Utils\Response;
use App\Utils\Validator;

// GETでのアクセス防止
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::redirect('./signup.php');
}

$name = Validator::sanitize(filter_input(INPUT_POST, 'name') ?? '');
$email = Validator::sanitize(filter_input(INPUT_POST, 'email') ?? '');
$password = Validator::sanitize(filter_input(INPUT_POST, 'password') ?? '');
$passwordConfirm = Validator::sanitize(
    filter_input(INPUT_POST, 'passwordConfirm') ?? ''
);

try {
    $session = Session::getInstance();

    if (empty($name)) {
        throw new Exception('ユーザー名を入力してください。');
    }
    if (empty($email)) {
        throw new Exception('メールアドレスを入力してください。');
    }
    if (empty($password)) {
        throw new Exception('パスワードを入力してください。');
    }
    if ($password !== $passwordConfirm) {
        throw new Exception('パスワードが一致しません。');
    }

    $userName = new UserName($name);
    $userEmail = new Email($email);
    $userPassword = new InputPassword($password);
    $input = new SignUpInput($userName, $userEmail, $userPassword);

    $usecase = new SignUpInteractor($input);
    $presenter = new SignUpPresenter($usecase->handle());
    $signUp = $presenter->view();

    if (!$signUp['isSuccess']) {
        throw new Exception($signUp['message']);
    }

    $session->appendMessage($signUp['message']);
    Response::redirect('./signin.php');
} catch (Exception $e) {
    $formData = compact('name', 'email', 'password', 'passwordConfirm');
    $session->setFormInputs($formData);
    $session->appendError($e->getMessage());

    Response::redirect('./signup.php');
}
