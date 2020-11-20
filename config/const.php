<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'addressbook');
define('DB_USER', 'user');
define('DB_PASS', '1234');

define('DOMEN', '/AddressBook/');
define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'] . DOMEN);
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . DOMEN);
define('IMAGES_URL', SITE_URL . 'userImages/');
define('IMAGES_PATH', SITE_ROOT . 'userImages/');

define('CLIENT_PATH', SITE_ROOT.'client/dist/index.html');
