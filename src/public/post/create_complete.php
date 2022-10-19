<?php
require_once '../../vendor/autoload.php';

use App\Adapter\Presenter\PostCreatePresenter;
use App\Usecase\CreateArticle\CreateArticleInput;
use App\Usecase\CreateArticle\CreateArticleInteractor;
use App\Domain\ValueObject\Article\ArticleTitle;
use App\Domain\ValueObject\Article\ArticleContents;
use App\Utils\Session;
use App\Utils\Response;
use App\Utils\Validator;

// GETでのアクセス防止
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::redirect('./create.php');
}

$title = Validator::sanitize(filter_input(INPUT_POST, 'title') ?? '');
$contents = Validator::sanitize(filter_input(INPUT_POST, 'contents') ?? '');

try {
    $session = Session::getInstance();
    $user = $session->getUser();

    if (empty($title)) {
        throw new Exception('タイトルを入力してください。');
    }

    $articleTitle = new ArticleTitle($title);
    $articleContents = new ArticleContents($contents);
    $input = new CreateArticleInput($articleTitle, $articleContents);

    $usecase = new CreateArticleInteractor($input);
    $presenter = new PostCreatePresenter($usecase->handle());
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
