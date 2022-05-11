<?php
require_once '../../vendor/autoload.php';

use App\Utils\Session;
use App\Utils\Response;
use App\Utils\Validator;
use App\Domain\ValueObject\Post\PostTitle;
use App\Domain\ValueObject\Post\PostContents;

// GETでのアクセス防止
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::redirect('./signup.php');
}

$title = Validator::sanitize(filter_input(INPUT_POST, 'title') ?? '');
$contents = Validator::sanitize(filter_input(INPUT_POST, 'contents') ?? '');

try {
    $session = Session::getInstance();

    if (empty($title)) {
        throw new Exception('タイトルを入力してください。');
    }

    $postTitle = new PostTitle($title);
    $postContents = new PostContents($contents);
} catch (Exception $e) {
    $formData = compact('title', 'contents');
    $session->setFormInputs($formData);
    $session->appendError($e->getMessage());

    Response::redirect('./create.php');
}
