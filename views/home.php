<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
</head>

<body>
    <?php require_once "partials/header.php" ?>
    <?php if (isset($_SESSION["id"])): ?>
        <a href="dashboard">Dashboard</a>
    <?php endif; ?>
    <?php require_once "partials/search.php" ?>

    <?php if (count($blogs) > 0): ?>
        <?php foreach ($blogs as $blog) : ?>
            <fieldset>
                <h3><?php echo htmlspecialchars($blog["title"]) ?></h3>
                <pre><?php echo htmlspecialchars($blog["description"]) ?></pre>
                <p>tags: <?php echo htmlspecialchars($blog["tags"]) ?></p>
                <p>by: <?php echo htmlspecialchars($blog["name_as_author"]) ?></p>
                <p>like count: <?php echo htmlspecialchars($blog["likeCount"]) ?></p>

                <?php if (isset($_SESSION["id"])): ?>
                    <form action="blogLike" method="POST">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($blog["blogId"]) ?>">
                        <input type="submit" name="like" value="<?php echo htmlspecialchars($blog["likeStatus"]) ?>">
                    </form>
                <?php endif; ?>
            </fieldset>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No blogs!</p>
    <?php endif; ?>
</body>

</html>