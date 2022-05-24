<?php
require_once '../vendor/autoload.php';

use App\Adapter\Presenter\HomePresenter;
use App\UseCase\FetchArticles\FetchArticlesInput;
use App\UseCase\FetchArticles\FetchArticlesInteractor;
use App\Domain\ValueObject\Order;
use App\Domain\ValueObject\Article\ArticleKeyword;
use App\Utils\Response;
use App\Utils\Session;

$session = Session::getInstance();
$messages = $session->popMessages();
$errors = $session->popErrors();
$user = $session->getUser();
if (is_null($user)) {
    Response::redirect('./user/signin.php');
}
$order = filter_input(INPUT_GET, 'order') ?? null;
$keyword = filter_input(INPUT_GET, 'keyword') ?? '';

try {
    $articleOrder = is_null($order) ? null : new Order($order);
    $articleKeyword = new ArticleKeyword($keyword);
    $input = new FetchArticlesInput($articleOrder, $articleKeyword);

    $usecase = new FetchArticlesInteractor($input);
    $presenter = new HomePresenter($usecase->handle());
    $homeViewModel = $presenter->view();
} catch (Exception $e) {
    $errors[] = $e->getMessage();
}
?><!doctype html>
<html>
<head>
<meta charset="UTF-8"> 
<meta http-equiv="content-language" content="ja"> 
<meta name="description" content="会員登録"> 
<title>記事詳細ページ : マイページ</title>
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<?php require_once './includes/header.php'; ?>
  <div class="container">
    <article class="article">
      <h1 class="article__heading">blog一覧</h1>
<?php foreach ($errors as $e): ?>
      <div class="error"><?php echo $e; ?></div>
<?php endforeach; ?>
      <div class="article__body">
        <div class="article__datetime">投稿日：あああああああああ</div>
        <div class="article__contents">
          ああああああああああああああ
        </div>
      </div>
    </article>
  </div>
</body>
</html>