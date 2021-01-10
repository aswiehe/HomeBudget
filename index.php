<?php

require_once('env/postbin.php');
header('Location: /pages/home.php');

?>

<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
    <details>
        <summary>Dashboard</summary>
        <?php require_once("./env/dashboard.php"); ?>
    </details>
    <h1>
    INDEX
    </h1>
</body>
</html>
