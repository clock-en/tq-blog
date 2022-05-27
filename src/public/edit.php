<!doctype html>
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
      <div class="article__body">
        <div class="article__field">
          <div class="article__field__name">タイトル</div>
          <div class="article__field__value">
            <input class="offstyle-input" name="title" maxlength="255" value="aaaaaaa">
          </div>
        </div>
        <div class="article__field">
          <div class="article__field__name">内容</div>
          <div class="article__field__value">
            <textarea class="offstyle-input" name="contents" maxlength="255">aaaaaa</textarea>
          </div>
        </div>
      </div>
    </article>
  </div>
</body>
</html>