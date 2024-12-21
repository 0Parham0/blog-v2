<!DOCTYPE html>
<html>

<head>
</head>

<body>
    <?php if (isset($_SESSION["id"])): ?>
        <span><?php echo $_SESSION["name"] ?></span>
        <br>
        <form action="logout" method="POST">
            <input type="submit" value="logout" name="logout">
        </form>
    <?php else: ?>
        <a href="signup">Sign Up</a>
        <br>
        <a href="login">Login</a>
    <?php endif ?>
</body>

</html>