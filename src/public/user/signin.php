<?php
require_once '../modules/Utils.php';
require_once '../modules/DBManager.php';

$errors = [];
$values = [];

function fetchUser(string $email, string $password)
{
    $db = new DBManager();
    $sql = 'SELECT * FROM users WHERE email=:email AND password=:password';
    $stmt = $db->connection->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', hash('sha256', $password), PDO::PARAM_STR);
    $res = $stmt->execute();
    if (!$res) {
        throw new PDOException('予期せぬ不具合が発生しました。');
    }
    $user = $stmt->fetch();
    return $user;
}

session_start();

if (isset($_SESSION['login'])) {
    session_regenerate_id(true);
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values = Utils::array_sanitize($_POST);
    if ($values['email'] === '') {
        $errors['email'] = 'メールアドレスを入力してください。';
    }
    if ($values['password'] === '') {
        $errors['password'] = 'パスワードを入力してください。';
    }
    if (is_array($errors) && empty($errors)) {
        try {
            $user = fetchUser($values['email'], $values['password']);
            if (empty($user)) {
                $errors['system'] =
                    'メールアドレスまたはパスワードが違います。';
            } else {
                session_regenerate_id(true);
                $_SESSION['login'] = [
                    'name' => $user['name'],
                    'email' => $user['email'],
                ];
                header('Location: ../index.php');
                exit();
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
<meta name="description" content="ログインフォーム"> 
<title>サインイン</title>
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
  <div class="container">
    <h1>ログイン</h1>
    <form method="POST" novalidate>
<?php if (!empty($errors['system'])): ?>
    <div class="error"><?php echo $errors['system']; ?>
<?php endif; ?>
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
        <button type="submit">ログイン</button>
      </div>
      <div>
        <a href="./signup.php">アカウントを作る</a>
      </div>
    </form>
  </div>
</body>
</html>