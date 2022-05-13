<?php
require_once '../../vendor/autoload.php';

use App\Utils\Session;

$session = Session::getInstance();
$formInputs = $session->popFormInputs();
$errors = $session->popErrors();

$title = $formInputs['title'] ?? '';
$contents = $formInputs['contents'] ?? '';
?><!doctype html>
<html>
<head>
<meta charset="UTF-8"> 
<meta http-equiv="content-language" content="ja"> 
<meta name="description" content="新規記事"> 
<title>新規記事</title>
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<?php require_once '../includes/header.php'; ?>
  <div class="container">
    <h1>新規記事</h1>
<?php foreach ($errors as $e): ?>
    <div class="error"><?php echo $e; ?></div>
<?php endforeach; ?>
    <form method="POST" action="./create_complete.php" novalidate>
      <div>
        <input name="title" maxlength="255" value="<?php echo $title; ?>">
      </div>
      <div>
        <textarea name="contents" maxlength="255"><?php echo $contents; ?></textarea>
      </div>
      <div>
        <button type="submit">新規作成</button>
      </div>
    </form>
  </div>
</body>
</html>