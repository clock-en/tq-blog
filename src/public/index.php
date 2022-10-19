<?php
require_once '../vendor/autoload.php';

use App\Adapter\Presenter\HomePresenter;
use App\Usecase\FetchArticles\FetchArticlesInput;
use App\Usecase\FetchArticles\FetchArticlesInteractor;
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
<title>blog一覧</title>
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<?php require_once './includes/header.php'; ?>
  <div class="container container--left">
    <h1>blog一覧</h1>
<?php foreach ($errors as $e): ?>
    <div class="error"><?php echo $e; ?></div>
<?php endforeach; ?>
    <div class="search">
      <form method="get">
        <input type="hidden" name="order" value="<?php echo $order; ?>">
        <input name="keyword" maxlength="255" value="<?php echo $keyword; ?>">
        <button>検索</button>
      </form>
    </div>
    <div class="sort">
      <form method="get" action="./?keyword=<php? echo $keyword?>">
        <button name="order" value="desc">新しい順</button>
        <button name="order" value="asc">古い順</button>
        <input type="hidden" name="keyword" value="<?php echo $keyword; ?>">
      </form>
    </div>
    <div class="entries">
<?php if ($homeViewModel['isSuccess'] && !empty($homeViewModel['articles'])): ?>
      <ul class="entry-list">
  <?php foreach ($homeViewModel['articles'] as $article): ?>
        <li class="entry">
          <div class="entry__header">
            <h2 class="entry__title"><?php echo $article['title']; ?></h2>
            <div class="entry__datetime">
              <?php echo $article['createdAt']; ?>
            </div>
          </div>
          <div class="entry__body">
            <?php echo $article['contents']; ?>
          </div>
          <div class="entry__footer">
            <a class="entry__button" href="/detail.php?id=<?php echo $article[
                'id'
            ]; ?>">記事詳細へ</a>
          </div>
        </li>
  <?php endforeach; ?>
      </ul>
<?php else: ?>
      <p><?php echo $homeViewModel['message']; ?></p>
<?php endif; ?>
    </div>
  </div>
</body>
</html>