<?php

require_once __DIR__ . '/functions.php';
$name = '';
$password = '';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name');
    $password = filter_input(INPUT_POST, 'password');

    $errors = signup_validate($name, $password);
    if (empty($errors)) {
        insert_user($name, $password);

        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_head.html' ?>

<body>
    <?php include_once __DIR__ . '/_heder.html' ?>
    <div class="wrapper">
        <h1 class="title">焼鳥まんぼう 新規登録</h1>
        <?php if ($errors) : ?>
            <ul class="errors">
                <?php foreach ($errors as $error) : ?>
                    <li><?= h($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form action="" method="post">
            <label for="name">ユーザー名</label>
            <input type="text" name="name" id="name" placeholder="UserName" value="<?= h($name) ?>">
            <label for="password">電話番号</label>
            <input type="password" name="password" id="password" placeholder="Password" value="<?= h($password) ?>">
            <div class="btn-area">
                <input type="submit" value="新規登録" class="btn submit-btn">
                <a href="login.php" class="btn link-btn">ログインはこちら</a>
            </div>
        </form>
    </div>
    <?php include_once __DIR__ . '/_footer.html' ?>
</body>

</html>