<?php
require_once __DIR__ . '/functions.php';

session_start();

if (!empty($_SESSION['id'])) {
    header('Location: show.php');
    exit;
}

$name = '';
$password = '';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name');
    $password = filter_input(INPUT_POST, 'password');

    $errors = signup_validate($name, $password);
    if (empty($errors)) {
        $user = find_user_by_password($name);
    
        if (password_verify($password, $user['tel'])) {
            $_SESSION['id'] = $user['id'];
            header('Location: show.php');
            exit;
        } else {
            $errors [] = MSG_EMAIL_PASSWORD_NOT_MATCH;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_head.html' ?>


<body>
    <?php include_once __DIR__ . '/_heder.html' ?>
    <div class="wrapper">
        <h1 class="title">Log In</h1>
        <?php if ($errors) : ?>
            <ul class="errors">
                <?php foreach ($errors as $error) : ?>
                    <li><?= h($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form action="" method="post">
            <label for="name">ユーザー名</label>
            <input type="text" name="name" id="name" placeholder="ユーザー名" value="<?= h($name) ?>">
            <label for="password">電話番号</label>
            <input type="password" name="password" id="password" placeholder="電話番号" value="<?= h($password) ?>">
            <div class="btn-area">
                <input type="submit" value="ログイン" class="btn submit-btn">
                <a href="signup.php" class="btn link-btn">新規ユーザー登録はこちら</a>
            </div>
        </form>
    </div>
    <?php include_once __DIR__ . '/_footer.html' ?>
</body>

</html>