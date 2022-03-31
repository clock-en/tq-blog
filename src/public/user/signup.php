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
        <input name="name" placeholder="ユーザー名" maxlength="255"<?php if (
            !empty($values['name'])
        ) {
            echo ' value="' . $values['name'] . '"';
        } ?>>
<?php if (!empty($errors['name'])): ?>
        <div class="error"><?php echo $errors['name']; ?>
<?php endif; ?>
      </div>
      <div>
        <input name="email" placeholder="メールアドレス" maxlength="255"<?php if (
            !empty($values['email'])
        ) {
            echo ' value="' . $values['email'] . '"';
        } ?>>
<?php if (!empty($errors['email'])): ?>
        <div class="error"><?php echo $errors['email']; ?>
<?php endif; ?>
      </div>
      <div>
        <input type="password" name="password" placeholder="Password" maxlength="20"<?php if (
            !empty($values['password'])
        ) {
            echo ' value="' . $values['password'] . '"';
        } ?>>
<?php if (!empty($errors['password'])): ?>
        <div class="error"><?php echo $errors['password']; ?>
<?php endif; ?>
      </div>
      <div>
        <input type="password" name="password_confirm" placeholder="Password確認" maxlength="20"<?php if (
            !empty($values['password_confirm'])
        ) {
            echo ' value="' . $values['password_confirm'] . '"';
        } ?>>
<?php if (!empty($errors['password_confirm'])): ?>
        <div class="error"><?php echo $errors['password_confirm']; ?>
<?php endif; ?>
      </div>
      <button type="submit">送信</button>
    </form>
  </div>
</body>
</html>