<?php
/**
 * @var array $_data_
 * @var string $restoreLink
 */

?>

<html lang="en">
<head>
    <title>Restore</title>
</head>
<body>
<h1>Forgot your password?</h1>
<div>
    <?php if ($restoreLink): ?>
        <a href="<?= $restoreLink ?>">Click here to restore your password</a>

    <?php else: ?>
        <form action="/?route=restore" method="post">
            <div class="form__input">
                <label>Type your login</label>
                <input name="login" type="text"/>
                <p style="color:red"><?= $errors['login'] ?? '' ?></p>
            </div>
            <br>
            <p style="color:red"><?= $errors['general'] ?? '' ?></p>
            <button type="submit">
                Restore
            </button>
        </form>
    <?php endif; ?>

</div>
</body>
</html>
