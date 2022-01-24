<?php
require_once __DIR__ . '/config.php';

// 接続処理を行う関数
function connect_db()
{
    try {
        return new PDO(
            DSN,
            USER,
            PASSWORD,
            [PDO::ATTR_ERRMODE =>
            PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

// エスケープ処理を行う関数
function h($str)
{
    // ENT_QUOTES: シングルクオートとダブルクオートを共に変換する。
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function signup_validate($name, $password){
    $errors = [];
    if (empty($name)) {
        $errors[] = MSG_NAME_REQUIRED;
    }
    if (empty($password)) {
        $errors[] = MSG_TELEPHONE_REQUIRED;
    }
    return $errors;
}

function insert_user($name, $password) {
    $dbh = connect_db();

    $sql = <<<EOM
        INSERT INTO
            users
            (name, tel)
        VALUES
            (:name, :tel);
        EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $pw_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bindParam(':tel', $pw_hash, PDO::PARAM_STR);
    $stmt->execute();

}

function insert_oder($user_id, $category_id, $age) {
    $dbh = connect_db();

    $sql = <<<EOM
        INSERT INTO
            orders
            (user_id, category_id, age)
        VALUES
            (:user_id, :category_id, :age);
        EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_STR);
    $stmt->bindParam(':age', $age, PDO::PARAM_STR);
    $stmt->execute();
}

function find_user_by_password($name) {
    $dbh = connect_db();

    $sql =<<<EOM
    SELECT
        *
    FROM
        users
    WHERE
        name = :name;
    EOM;
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function find_user_by_id($id) {
    $dbh = connect_db();

    $sql = <<<EOM
    SELECT
        *
    FROM
        users
    WHERE
        id = :id;
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam('id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function categories($stmt) {
    $dbh = connect_db();

    $sql = <<<EOM
    SELECT
        *
    FROM
        categories
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function find_by_status($status) {
    $dbh = connect_db();

    $sql =<<<EOM
    SELECT
        *
    FROM
        categories
    JOIN
        orders
    ON
        orders.category_id = categories.id
    WHERE
    status = :status
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function insert_validate($category_id, $age) {
    $errors = [];
    if ($category_id == '') {
        $errors[] = ('焼き鳥を注文して下さい');
    }
    if ($age == '') {
        $errors[] = ('本数を入力して下さい');
    }
    return $errors;
}

function create_err_msg($errors) {
    $err_msg = "<ul class=\"errors\">\n";
    foreach($errors as $error) {
        $err_msg .= "<li>" . h($error) . "</li>\n";
    }
    $err_msg .= "</ul>\n";
    return $err_msg;
}

function update_status_done($id){
    $dbh = connect_db();
    $sql =<<<EOM
    UPDATE
        orders
    SET
        status = 'done'
    WHERE
    id = :id
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function delete_task($id) {
    $dbh = connect_db();
    $sql =<<<EOM
    DELETE FROM
        orders
    WHERE
        id = :id
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function find_by_id($id) {
    $dbh = connect_db();
    $sql =<<<EOM
    SELECT
        *
    FROM
        orders
    WHERE
        id = :id
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update_validate($category, $age) {
    $errors = [];
    if ($category == '') {
        $errors[] = '注文をお願いします';
    }
    if ($age == '') {
        $errors[] = '本数をおねがいします';
    }
    return $errors;
}

function update_task($id, $category_id, $age) {
    $dbh = connect_db();
    $sql = <<<EOM
    UPDATE
        orders
    SET
        category_id = :category_id,
        age = :age
    WHERE
        id = :id
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_STR);
    $stmt->bindParam(':age', $age, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function update_status_end($id)
{
    $dbh = connect_db();
    $sql = <<<EOM
    UPDATE
        orders
    SET
        status = 'end'
    WHERE
    id = :id
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}