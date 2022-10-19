<?php
require_once '../vendor/autoload.php';

use App\Adapter\Presenter\EditPresenter;
use App\UseCase\UpdateArticle\UpdateArticleInput;
use App\UseCase\UpdateArticle\UpdateArticleInteractor;
use App\Domain\ValueObject\Article\ArticleId;
use App\Domain\ValueObject\Article\ArticleTitle;
use App\Domain\ValueObject\Article\ArticleContents;
use App\Utils\Session;
use App\Utils\Response;
use App\Utils\Validator;

// GETでのアクセス防止
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::redirect('./edit.php');
}

$id = Validator::sanitize(filter_input(INPUT_POST, 'id') ?? null);
$title = Validator::sanitize(filter_input(INPUT_POST, 'title') ?? '');
$contents = Validator::sanitize(filter_input(INPUT_POST, 'contents') ?? '');

try {
    $session = Session::getInstance();
    $user = $session->getUser();

    if (empty($title)) {
        throw new Exception('タイトルを入力してください。');
    }
    if ($id === '' || is_null($id)) {
        throw new Exception('テスト：不正な値が送信されました。');
    }

    $articleId = new ArticleId($id);
    $articleTitle = new ArticleTitle($title);
    $articleContents = new ArticleContents($contents);
    $input = new UpdateArticleInput(
        $articleId,
        $articleTitle,
        $articleContents
    );

    $usecase = new UpdateArticleInteractor($input);
    $presenter = new EditPresenter($usecase->handle());
    $result = $presenter->view();

    if (!$result['isSuccess']) {
        throw new Exception($result['message']);
    }

    $session->appendMessage($result['message']);
    Response::redirect('./myArticleDetail.php?id=' . $articleId->value());
} catch (Exception $e) {
    $formData = compact('title', 'contents');
    $session->setFormInputs($formData);
    $session->appendError($e->getMessage());

    Response::redirect('./edit.php?id=' . $id);
}
