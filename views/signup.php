<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
</head>

<body>
    <a href="home">Home</a>
    <br>
    <a href="login">Login</a>
    <form action="signupSubmit" method="POST">
        <fieldset>
            <legend>Sign Up</legend>
            <?php if (isset($errors)): ?>
                <p style="color: red;">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error ?></p>
                        <br>
                    <?php endforeach; ?>
                </p>
            <?php endif; ?>
            <label for="fName">First Name: </label>
            <input type="text" id="fName" name="fName" value="<?php echo htmlspecialchars(isset($fName) ? $fName : ""); ?>">
            <br>
            <label for="lName">Last Name: </label>
            <input type="text" id="lName" name="lName" value="<?php echo htmlspecialchars(isset($lName) ? $lName : ""); ?>">
            <br>
            <label for="author">Name As Author: </label>
            <input type="text" id="author" name="nameAsAuthor" value="<?php echo htmlspecialchars(isset($nameAsAuthor) ? $nameAsAuthor : ""); ?>">
            <br>
            <label for="email">Email: </label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars(isset($email) ? $email : ""); ?>">
            <br>
            <label for="password">Password: </label>
            <input type="password" name="password" id="password" minlength="8" placeholder="at least 8 characters">
            <br>
            <label for="conPassword">Confirm Password: </label>
            <input type="password" name="conPassword" id="conPassword" minlength="8" placeholder="at least 8 characters">
            <br>
            <input type="submit" value="Submit">
        </fieldset>
    </form>
</body>

</html>