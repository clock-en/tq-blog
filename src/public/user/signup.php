<?php
require_once '../modules/Utils.php';
require_once '../modules/DBManager.php';

$errors = [];
$values = [];

function isUniqueEmail(string $email)
{
    $db = new DBManager();
    $sql = 'SELECT email FROM users WHERE email=:email';
    $stmt = $db->connection->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $res = $stmt->execute();
    if (!$res) {
        throw new PDOException('予期せぬ不具合が発生しました。');
    }
    $data = $stmt->fetch();
    if (!$data) {
        return true;
    }
    return false;
}
function insertUser($values)
{
    $db = new DBManager();
    $insertSQL =
        'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';
    $stmt = $db->connection->prepare($insertSQL);
    $stmt->bindParam(':name', $values['name'], PDO::PARAM_STR);
    $stmt->bindParam(':email', $values['email'], PDO::PARAM_STR);
    $stmt->bindParam(
        ':password',
        hash('sha256', $values['password']),
        PDO::PARAM_STR
    );
    $res = $stmt->execute();
    if (!$res) {
        throw new PDOException('予期せぬ不具合が発生しました。');
    }
    header('Location: ./signin.php');
}

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
        try {
            if (!isUniqueEmail($values['email'])) {
                $errors['email'] = '入力したパスワードは既に入力済みです。';
            } else {
                insertUser($values);
            }
        } catch (PDOException $e) {
            echo 'Fatal Error: ' . $e->getMessage();
            die();
        }
    }
}

// TODO: 登録後の戻るや更新を行った際にPOSTされてしまうのを防ぎたい
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
<?php if (!empty($errors['system'])): ?>
        <div class="error"><?php echo $errors['system']; ?>
<?php endif; ?>
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
      <div>
        <button type="submit">アカウント作成</button>
      </div>
      <div>
        <a href="./signin.php">ログイン画面へ</a>
      </div>
    </form>
  </div>
</body>
</html>