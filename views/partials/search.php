<!DOCTYPE html>
<html>

<head>
</head>

<body>
    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="GET">
        <select name="searchBetween">
            <option value="all" selected>all</option>
            <option value="description">description</option>
            <option value="title">title</option>
            <option value="name_as_author">author</option>
        </select>
        <input type="search" name="searchText">
        <input type="submit" value="search" name="search">
    </form>
</body>

</html>