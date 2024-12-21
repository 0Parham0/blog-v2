<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <a href="home">Home</a>
    <br>
    <a href="signup">Sign up</a>
    <form action="loginSubmit" method="POST">
        <fieldset>
            <legend>Login</legend>
            <?php if (isset($errors)): ?>
                <p style="color: red;">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error ?></p>
                        <br>
                    <?php endforeach; ?>
                </p>
            <?php endif; ?>
            <label for="email">Email: </label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars(isset($email) ? $email : ""); ?>">
            <br>
            <label for="password">Password: </label>
            <input type="password" name="password" id="password" minlength="8" placeholder="at least 8 characters">
            <br>
            <input type="submit" value="Submit">
        </fieldset>
    </form>
</body>

</html>