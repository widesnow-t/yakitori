<?php

use phpDocumentor\Reflection\Location;

require_once __DIR__ .'/functions.php';
require_once __DIR__ . '/config.php';

    $user_id = filter_input(INPUT_POST, 'user_id');
    $category_id = filter_input(INPUT_POST, 'category_id');
    $pon = filter_input(INPUT_POST, 'pon');

    insert_oder($user_id, $category_id, $pon);
    header('Location: show.php');
    exit;
?>