<?php
/*use Lib\Feed as Feed;
use Lib\Log as Log;
use Lib\Token as Token;
use Lib\Cleanse as Cleanse;*/

require_once(__DIR__ . '/vendor/autoload.php');

require_once('connection.php');

if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action = $_GET['action'];
} else {
    $controller = 'pages';
    $action = 'home';
}

require_once('views/layout.php');

/*
$feed = new Feed();
$log = new Log();
$token = new Token();
$validator = new Cleanse();
*/

?>