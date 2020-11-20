<?php

require_once('config/const.php');
require_once('vendor/autoload.php');

use AddressBook\Contact\Controller\ApiController;

$response = null;

//Если есть параметры, то на api
$params = explode('/', $_GET['req']);
if (isset($params) && $params[0] == 'api') {
    $api = new ApiController();
    $response = $api->process($params);
    echo ($response);
} else {
    //front
    include(CLIENT_PATH);
}
