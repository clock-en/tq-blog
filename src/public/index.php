<?php
require_once '../vendor/autoload.php';

use App\Utils\Session;

$session = Session::getInstance();
$user = $session->getUser();
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
    <div class="search">
      <form>
        <input name="search" maxlength="255">
        <button>検索</button>
      </form>
    </div>
    <div class="sort">
      <form>
        <input type="hidden" name="desc">
        <button>新しい順</button>
      </form>
      <form>
        <input type="hidden" name="asc">
        <button>古い順</button>
      </form>
    </div>
    <div class="entries">
      <ul class="entry-list">
        <li class="entry">
          <div class="entry__header">
            <h2 class="entry__title">記事タイトル</h2>
            <div class="entry__datetime">日時</div>
          </div>
          <div class="entry__body">
            <div class="entry__outline">記事本文記事本文記事本文記事本文記事本文記事本文記事本文記事本文記事本文</div>
          </div>
          <div class="entry__footer">
            <a class="entry__button" href="/detail.php?id=1">記事詳細へ</a>
          </div>
        </li>
        <li class="entry">
          <div class="entry__header">
            <h2 class="entry__title">記事タイトル</h2>
            <div class="entry__datetime">日時</div>
          </div>
          <div class="entry__body">
            <div class="entry__outline">記事本文記事本文記事本文記事本文記事本文記事本文記事本文記事本文記事本文</div>
          </div>
          <div class="entry__footer">
            <a class="entry__button" href="/detail.php?id=1">記事詳細へ</a>
          </div>
        </li>
        <li class="entry">
          <div class="entry__header">
            <h2 class="entry__title">記事タイトル</h2>
            <div class="entry__datetime">日時</div>
          </div>
          <div class="entry__body">
            <div class="entry__outline">記事本文記事本文記事本文記事本文記事本文記事本文記事本文記事本文記事本文</div>
          </div>
          <div class="entry__footer">
            <a class="entry__button" href="/detail.php?id=1">記事詳細へ</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</body>
</html>