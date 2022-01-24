<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
//セッション開始
session_start();
$user_id = '';
$category_id = '';
$age = '';

//ログイン判定
if (empty($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}
$current_user = find_user_by_id($_SESSION['id']);
$categories = categories($stmt);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = filter_input(INPUT_POST, 'user_id');
    $category_id = filter_input(INPUT_POST, 'category');
    $age = filter_input(INPUT_POST, 'age');
    $errors = insert_validate($category_id, $age);
    if (empty($errors)) {
        insert_oder($user_id, $category_id, $age);
    }
}
$notyet_tasks = find_by_status('notyet');
$done_tasks = find_by_status('done');
$end_tasks = find_by_status('end');
?>
<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_head.html'; ?>

<body>
        <div class="wrapper">
            <h1 class="title">注文画面</h1>
            <h2 class="sub-title"><?= h($current_user['name']) ?>さん ようこそ!</h2>
            <p class="info">ご注文ください</p>
            <?php if ($errors) echo (create_err_msg($errors)) ?>
            <form action="" method="post">
                <input type="hidden" name="user_id" value="<?= $current_user['id'] ?>">
                <select name="category" id="">
                    <option value=""></option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id'] ?>" <?= $selected['category'][$category['id']] ?>><?= $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="age" value="">
                <input type="submit" value="決定" class="btn submit-btn">
            </form>
            <div class="notyet-task">
                <h2>ご確認下さい!</h2>
                <ul>
                    <?php foreach ($notyet_tasks as $task) : ?>
                        <li>
                            <a href="done.php?id=<?= h($task['id']) ?>" class="btn done-btn">確認</a>
                            <a href="edit.php?id=<?= h($task['id']) ?>" class="btn edit-btn">変更</a>
                            <a href="delete.php?id=<?= h($task['id']) ?>" class="btn delete-btn">削除</a>
                            <?= h($task['name']) ?>
                            <?= h($task['age']) ?>
                        </li>
                        <hr>
                    <?php endforeach; ?>
                </ul>
            </div>
            <hr>
            <div class="done-task">
                <h2>OKボタンを押して下さい</h2>
                <ul>
                    <?php foreach ($done_tasks as $task) : ?>
                        <?php $sum += ($task['price']*$task['age']); ?>
                        <li>
                            <a href="end.php?id=<?= h($task['id']) ?>" class="btn end-btn">OK</a>
                            <a href="delete.php?id=<?= h($task['id']) ?>" class="btn delete-btn">削除</a>
                            <?= h($task['name']) ?>
                            <?= h($task['age']) ?>
                        </li>
                        <hr>
                    <?php endforeach; ?>
                </ul>
                <p>合計:<?= number_format($sum) ?>円</p>
            </div>
            <div class="btn-area">
                <a href="logout.php" class="btn log-out-btn">ログアウト</a>
            </div>
        </div>
</body>

</html>