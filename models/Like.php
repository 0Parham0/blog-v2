<?php

require_once __DIR__ . "/Model.php";

class Like extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function readBlogLikeCount($blogId)
    {
        $sql = "SELECT COUNT(user_id) AS likeCount 
                FROM likes
                WHERE blog_id = :blog_id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":blog_id", $blogId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function readBlogUserLikeStatus($blogId, $userId)
    {
        $sql = "SELECT blog_id
                FROM likes
                WHERE blog_id = :blog_id AND user_id = :user_id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":blog_id", $blogId, PDO::PARAM_INT);
        $statement->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function likeBlog($blogId, $userId)
    {
        $sql = "INSERT INTO likes (user_id, blog_id)  
                values (:user_id, :blog_id)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $statement->bindParam(":blog_id", $blogId, PDO::PARAM_INT);
        $statement->execute();
    }

    public function unlikeBlog($blogId, $userId)
    {
        $sql = "DELETE FROM likes  
                WHERE blog_id = :blog_id AND user_id = :user_id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $statement->bindParam(":blog_id", $blogId, PDO::PARAM_INT);
        $statement->execute();
    }

    public function deleteBlogLikes($blogId)
    {
        $sql = "DELETE FROM likes  
                WHERE blog_id = :blog_id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":blog_id", $blogId, PDO::PARAM_INT);
        $statement->execute();
    }
}
