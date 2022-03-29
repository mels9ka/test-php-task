<?php

use controllers\UserController;

/**
 * @var array $_data_
 * @var UserController $this
 * @var string $title
 * @var string $scenario
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
    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
        <?php if ($scenario === $this::USER_RESTORE_SCENARIO): ?>
            <div class="form__input">
                <label>Old password</label>
                <input name="password_old" type="password"/>
                <p style="color:red"><?= $errors['password_old'] ?? '' ?></p>
            </div>
            <br>
        <?php endif; ?>
        <div class="form__input">
            <label>New password</label>
            <input name="password_new" type="password"/>
            <p style="color:red"><?= $errors['password_new'] ?? '' ?></p>
        </div>
        <br>
        <div class="form__input">
            <label>Repeat new password</label>
            <input name="password_new_repeat" type="password"/>
            <p style="color:red"><?= $errors['password_new_repeat'] ?? '' ?></p>
        </div>
        <p style="color:red"><?= $errors['general'] ?? '' ?></p>
        <button type="submit">
            Change password
        </button>
    </form>
</div>
</body>
</html>
