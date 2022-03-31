<?php
require_once '../functions/Utils.php';
$errors = [];
$values = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values = Utils::array_sanitize($_POST);
    if ($values['name'] === '') {
        $errors['name'] = 'ユーザー名を入力してください。';
    }
    if ($values['email'] === '') {
        $errors['email'] = 'メールアドレスを入力してください。';
    }
    if ($values['password'] === '') {
        $errors['password'] = 'パスワードを入力してください。';
    }
    if (
        is_null($errors['password']) &&
        $values['password'] !== $values['password_confirm']
    ) {
        $errors['password_confirm'] = 'パスワードが一致しません。';
    }
    if (is_array($errors) && empty($errors)) {
        echo 'データは正常';
    }
}
?><!doctype html>
<html>
<head>
<meta charset="UTF-8"> 
<meta http-equiv="content-language" content="ja"> 
<meta name="description" content="会員登録"> 
<title>会員登録</title>
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
  <div class="container">
    <h1>会員登録</h1>
    <form method="POST" novalidate>
      <div>
        <input name="name" placeholder="ユーザー名" maxlength="255">
      </div>
      <div>
        <input name="email" placeholder="メールアドレス" maxlength="255">
      </div>
      <div>
        <input type="password" name="password" placeholder="Password" maxlength="20">
      </div>
      <div>
        <input type="password" name="password_confirm" placeholder="Password確認" maxlength="20">
      </div>
      <button type="submit">送信</button>
    </form>
  </div>
</body>
</html>