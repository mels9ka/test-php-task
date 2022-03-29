<?php
/**
 * @var array $_data_
 * @var string $title
 * @var array $errors
 */
?>

<html lang="en">
<head>
    <title><?= $title ?></title>
</head>
<body>
<h1><?= $title ?></h1>
<div>
    <form action="/?route=login" method="post">
        <div class="form__input">
            <label>Login</label>
            <input name="login" type="text"/>
            <p style="color:red"><?= $errors['login'] ?? '' ?></p>
        </div>
        <div class="form__input">
            <label>Password</label>
            <input name="password" type="password"/>
            <p style="color:red"><?= $errors['password'] ?? '' ?></p>
        </div>
        <br>
        <p style="color:red"><?= $errors['general'] ?? '' ?></p>
        <button type="submit">
            Login
        </button>
    </form>
</div>
</body>
</html>
