<?php
require_once '../vendor/autoload.php';

use App\Adapter\Presenter\DetailPresenter;
use App\UseCase\FindArticle\FindArticleInput;
use App\UseCase\FindArticle\FindArticleInteractor;
use App\UseCase\FetchArticleComments\FetchArticleCommentsInput;
use App\UseCase\FetchArticleComments\FetchArticleCommentsInteractor;
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
    $articleInput = new FindArticleInput($articleId);
    $commentInput = new FetchArticleCommentsInput($articleId);

    $articleUsecase = new FindArticleInteractor($articleInput);
    $commentUsecase = new FetchArticleCommentsInteractor($commentInput);

    $presenter = new DetailPresenter(
        $articleUsecase->handle(),
        $commentUsecase->handle()
    );
    $detailViewModel = $presenter->view();
    // 取得に失敗した場合は Not Found
    if (!$detailViewModel['isSuccess']) {
        $session->appendError($detailViewModel['message']);
        Response::redirect('error.php', 404);
    }
    $article = $detailViewModel['article'];
    $comments = $detailViewModel['comments'];
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
<?php foreach ($messages as $m): ?>
      <div class="success"><?php echo $m; ?></div>
<?php endforeach; ?>
      <div class="article__body">
        <div class="article__datetime"><?php echo $article[
            'createdAt'
        ]; ?></div>
        <div class="article__field">
          <div class="article__field__value">
            <?php echo $article['contents']; ?>
          </div>
        </div>
        <div class="article__actions">
          <a class="button" href="/">一覧ページへ</a>
        </div>
      </div>
    </article>
    <section class="comment-form">
      <form method="post" action="/comment_complete.php">
        <div class="comment-form__body">
          <h1 class="comment-form__heading">この投稿にコメントしますか？</h1>
          <div class="comment-form__field">
            <div class="comment-form__field__name">コメント名</div>
            <div class="comment-form__field__value">
              <input class="offstyle-input" name="commenterName" maxlength="255" value="">
            </div>
          </div>
          <div class="comment-form__field">
            <div class="comment-form__field__name">内容</div>
            <div class="comment-form__field__value">
              <textarea class="offstyle-input" name="contents" maxlength="255"></textarea>
            </div>
          </div>
          <div class="comment-form__actions">
            <button class="button">コメント</button>
          </div>
        </div>
      </form>
    </section>
<?php if (!empty($comments)): ?>
    <aside class="comments">
      <h1 class="comments__heading">コメント一覧</h1>
      <ul class="comment-list">
  <?php foreach ($comments as $comment): ?>
        <li class="comment">
          <h2 class="comment__name">
            <?php echo $comment['commenterName']; ?>
          </h2>
          <div class="comment__datetime">
            <?php echo $comment['createdAt']; ?>
          </div>
          <div class="comment__body">
            <?php echo $comment['contents']; ?>
          </div>
        </li>
  <?php endforeach; ?>
      </ul>
    </aside>
<?php endif; ?>
  </div>
</body>
</html>