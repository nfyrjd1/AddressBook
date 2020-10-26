<?php
include_once 'config/const.php';
include_once DB_PATH;


$db = new mysql();

$view = isset($_GET['view']) ? $_GET['view'] : 'list';
$data = '';

switch ($view) {
    case 'card':
        include_once SRC_PATH . 'controller/ContactController.php';
        $controller = new ContactController();
        break;

    case 'list':
        include_once SRC_PATH . 'controller/ContactListController.php';
        $controller = new ContactListController();
        break;

    default:
        include_once SRC_PATH . 'controller/Error404Controller.php';
        $controller = new Error404Controller();
        break;
}

$data = $controller->process();


include_once 'template/index.php';
