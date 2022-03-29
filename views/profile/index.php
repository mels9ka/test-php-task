<?php

use controllers\BaseController;

/**
 * @var array $_data_
 * @var string $login
 * @var BaseController $this
 */


?>

<html lang="en">
<head>
    <title>Profile page</title>
</head>
<body>
<h1>Profile page</h1>
<h2>Hello <?= $login ?></h2>
<p style="color: green"><?= $this->getNotifications() ?></p>
<div>
    <a href="/?route=change-password">Change password</a>
    <br>
    <a href="/?route=logout">Logout</a>
</div>
</body>
</html>

