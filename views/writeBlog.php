<!DOCTYPE html>
<html>

<head>
    <title>Write Blog</title>
</head>

<body>
    <?php require_once "partials/header.php" ?>
    <a href="dashboard">Dashboard</a>
    <form action="blogSubmit" method="POST">
        <fieldset>
            <legend>Blog</legend>
            <?php if (isset($errors)): ?>
                <p style="color: red;">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error ?></p>
                        <br>
                    <?php endforeach; ?>
                </p>
            <?php endif; ?>
            <label for="title">Title: </label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars(isset($title) ? $title : ""); ?>">
            <br>
            <label for="description">Description: </label>
            <textarea cols="25" rows="5" id="description" name="description"><?php echo htmlspecialchars(isset($description) ? $description : ""); ?></textarea>
            <br>
            <label for="tags">Tags: </label>
            <input type="text" name="tags" id="tags" value="<?php echo htmlspecialchars(isset($tags) ? $tags : ""); ?>" placeholder="Write comma-separated!">
            <br>
            <input type="hidden" name="blogId" value="<?php echo htmlspecialchars(isset($blogId) ? $blogId : ""); ?>">
            <input type="submit" value="Submit">
        </fieldset>
    </form>
</body>

</html>