<?php
require_once __DIR__ . '/functions.php';

$id = filter_input(INPUT_GET, 'id');
$task = find_by_id($id);

$category = '';
$age = '';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = filter_input(INPUT_POST, 'category');
    $age = filter_input(INPUT_POST, 'age');
    $errors = update_validate($category, $age);

    if (empty($errors)) {
        update_task($id, $category, $age);
        
        header('Location: show.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_head.html' ?>

<body>
    <div class="wrapper">
        <h2>注文変更</h2>
        <?php if ($errors) echo (create_err_msg($errors)) ?>
        <form action="" method="post">
            <input type="text" name="category" value="<?= h($task['category']) ?>">
            <input type="text" name="age" value="<?= h($task['age']) ?>">
            <input type="submit" value="更新" class="btn submit-btn">
        </form>
        <a href="show.php" class="btn return-btn">戻る</a>
    </div>
</body>

</html>