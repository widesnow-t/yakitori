<?php
require_once __DIR__ . '/functions.php';

$id = filter_input(INPUT_GET, 'id');
update_status_end($id);
?>
<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_head.html' ?>

<body>
    <div class="wrapper">
        <h2>注文を完了しました!ありがとうございました!!</h2>
        <a href="show.php" class="btn return-btn">戻る</a>
    </div>
</body>

</html>