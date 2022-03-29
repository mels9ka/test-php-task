<?php
/**
 * @var array $_data_
 * @var bool $isGuest
 */
?>

<html lang="en">
<head>
    <title>Main page</title>
</head>
<body>
<h1>Main page</h1>
<div>
    <?php if ($isGuest): ?>
        <a href="/?route=login">Login</a>
        <br>
        <a href="/?route=registration">Registration</a>
    <?php else: ?>
        <a href="/?route=profile">Profile</a>
    <?php endif ?>
</div>
</body>
</html>
