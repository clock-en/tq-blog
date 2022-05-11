<?php
require_once '../../vendor/autoload.php';

use App\Adapter\Presenter\CreatePostPresenter;
use App\UseCase\CreatePost\CreatePostInput;
use App\UseCase\CreatePost\CreatePostInteractor;
use App\Domain\ValueObject\Post\PostTitle;
use App\Domain\ValueObject\Post\PostContents;
use App\Domain\ValueObject\User\UserId;
use App\Utils\Session;
use App\Utils\Response;
use App\Utils\Validator;

// GETでのアクセス防止
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::redirect('./signup.php');
}

$title = Validator::sanitize(filter_input(INPUT_POST, 'title') ?? '');
$contents = Validator::sanitize(filter_input(INPUT_POST, 'contents') ?? '');

try {
    $session = Session::getInstance();
    $user = $session->getUser();

    if (empty($title)) {
        throw new Exception('タイトルを入力してください。');
    }

    $postTitle = new PostTitle($title);
    $postContents = new PostContents($contents);
    $userId = new UserId($user['id']);
    $input = new CreatePostInput($postTitle, $postContents);

    $usecase = new CreatePostInteractor($userId, $input);
    $presenter = new CreatePostPresenter($usecase->handle());
    $result = $presenter->view();

    if (!$result['isSuccess']) {
        throw new Exception($result['message']);
    }

    $session->appendMessage($result['message']);
    Response::redirect('../mypage.php');
} catch (Exception $e) {
    $formData = compact('title', 'contents');
    $session->setFormInputs($formData);
    $session->appendError($e->getMessage());

    Response::redirect('./create.php');
}
