<?php

require_once __DIR__ . "/Model.php";

class Blog extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function readAll()
    {
        $sql = "SELECT blogs.id AS blogId, title, description, name_as_author 
                FROM blogs
                JOIN users ON user_id = users.id";
        $statement = $this->connection->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readWithUserId($userId)
    {
        $sql = "SELECT blogs.id AS blogId, title, description, name_as_author 
                FROM blogs
                JOIN users ON user_id = users.id
                WHERE user_id = :user_id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readWithSearch($searchBetween, $searchValue)
    {
        $sql = "SELECT blogs.id AS blogId, title, description, name_as_author 
        FROM blogs
        JOIN users ON user_id = users.id
        WHERE LOWER($searchBetween) LIKE LOWER(:searchValue)";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(":searchValue", '%' . $searchValue . '%');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readWithSearchBetweenAll($searchValue)
    {
        $sql = "SELECT blogs.id AS blogId, title, description, name_as_author 
        FROM blogs
        JOIN users ON user_id = users.id
        WHERE (LOWER(description) LIKE LOWER(:searchValue) OR LOWER(title) LIKE LOWER(:searchValue) OR LOWER(name_as_author) LIKE LOWER(:searchValue))";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(":searchValue", '%' . $searchValue . '%');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readWithUserIdAndSearch($userId, $searchBetween, $searchValue)
    {
        $sql = "SELECT blogs.id AS blogId, title, description, name_as_author 
                FROM blogs
                JOIN users ON user_id = users.id
                WHERE user_id = :user_id AND LOWER($searchBetween) LIKE LOWER(:searchValue)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $statement->bindValue(":searchValue", '%' . $searchValue . '%');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readWithUserIdAndSearchBetweenAll($userId, $searchValue)
    {
        $sql = "SELECT blogs.id AS blogId, title, description, name_as_author 
                FROM blogs
                JOIN users ON user_id = users.id
                WHERE user_id = :user_id AND (LOWER(description) LIKE LOWER(:searchValue) OR LOWER(title) LIKE LOWER(:searchValue) OR LOWER(name_as_author) LIKE LOWER(:searchValue))";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $statement->bindValue(":searchValue", '%' . $searchValue . '%');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function writeBlog($title, $description, $userId)
    {
        $sql = "INSERT INTO blogs (title, description, user_id)  
                values (:title, :description, :user_id)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $statement->bindParam(":title", $title);
        $statement->bindParam(":description", $description);
        $statement->execute();
        return $this->connection->lastInsertId();
    }

    public function deleteBlog($blogId)
    {
        $sql = "DELETE FROM blogs  
                WHERE id = :blog_id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":blog_id", $blogId, PDO::PARAM_INT);
        $statement->execute();
    }

    public function readBlogWithId($blogId)
    {
        $sql = "SELECT title, description, id 
                FROM blogs
                WHERE id = :blog_id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":blog_id", $blogId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function updateBlog($title, $description, $blogId)
    {
        $sql = "UPDATE blogs 
                SET title = :title, description = :description
                WHERE id = :blog_id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":title", $title);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":blog_id", $blogId, PDO::PARAM_INT);
        $statement->execute();
    }
}
