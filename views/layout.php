<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/styles.css" type="text/css" media="all" />
    <title>RSS Test</title>
</head>
<body>
<header>
    <a href='/'>Home</a>
    <h2>RSS Feeds</h2>
</header>

<?php
require_once(__DIR__ . '/../routes.php');
$route = new Route;
$route->set();
?>

<footer>

</footer>
</body>
</html>