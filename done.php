<?php
require_once __DIR__ . '/functions.php';
use phpDocumentor\Reflection\Location;

$id = filter_input(INPUT_GET, 'id');
update_status_done($id);
header('Location: show.php');
exit;
?>