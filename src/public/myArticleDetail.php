<?php
require_once '../vendor/autoload.php';

use App\Adapter\Presenter\MyArticleDetailPresenter;
use App\UseCase\FindArticle\FindArticleInput;
use App\UseCase\FindArticle\FindArticleInteractor;
use App\Domain\ValueObject\Article\ArticleId;
use App\Utils\Response;
use App\Utils\Session;

$session = Session::getInstance();
$messages = $session->popMessages();
$errors = $session->popErrors();
$user = $session->getUser();
if (is_null($user)) {
    Response::redirect('./user/signin.php');
}
$id = filter_input(INPUT_GET, 'id') ?? null;

try {
    $articleId = is_null($id) ? null : new ArticleId(intval($id));
    $input = new FindArticleInput($articleId);

    $usecase = new FindArticleInteractor($input);
    $presenter = new MyArticleDetailPresenter($usecase->handle());
    $myArticleViewModel = $presenter->view();
    // 取得に失敗した場合は Not Found
    if (!$myArticleViewModel['isSuccess']) {
        $session->appendError($myArticleViewModel['message']);
        Response::redirect('error.php', 404);
    }
    $article = $myArticleViewModel['article'];
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
      <h1 class="article__heading"><?php echo $article['title']; ?></h1>
      <div class="article__body">
        <div class="article__datetime"><?php echo $article[
            'createdAt'
        ]; ?></div>
        <div class="article__field">
          <div class="article__field__value">
            <?php echo $article['contents']; ?>
          </div>
        </div>
      </div>
    </article>
  </div>
</body>
</html>