<?php
require_once '../../vendor/autoload.php';

use App\Adapter\Presenter\SignInPresenter;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\InputPassword;
use App\UseCase\SignIn\SignInInput;
use App\UseCase\SignIn\SignInInteractor;
use App\Utils\Session;
use App\Utils\Response;
use App\Utils\Validator;

// GETでのアクセス防止
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::redirect('./signin.php');
}

$email = Validator::sanitize(filter_input(INPUT_POST, 'email') ?? '');
$password = Validator::sanitize(filter_input(INPUT_POST, 'password') ?? '');

try {
    $session = Session::getInstance();

    if (empty($email)) {
        throw new Exception('メールアドレスを入力してください。');
    }
    if (empty($password)) {
        throw new Exception('パスワードを入力してください。');
    }
    $userEmail = new Email($email);
    $userPassword = new InputPassword($password);
    $input = new SignInInput($userEmail, $userPassword);
    $usecase = new SignInInteractor($input);
    $presenter = new SignInPresenter($usecase->handle());
    $signIn = $presenter->view();

    if (!$signIn['isSuccess']) {
        throw new Exception($signIn['message']);
    }

    $session->appendMessage($signIn['message']);
    Response::redirect('../index.php');
} catch (Exception $e) {
    $formData = compact('email', 'password');
    $session->setFormInputs($formData);
    $session->appendError($e->getMessage());

    Response::redirect('./signin.php');
}
