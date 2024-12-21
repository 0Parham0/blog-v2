<?php

require_once __DIR__ . "/Model.php";

class Tag extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function readBlogTagNames($blogId)
    {
        $sql = "SELECT tags.name 
                FROM tags
                JOIN blog_tags ON tag_id = tags.id
                WHERE blog_id = :blog_id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":blog_id", $blogId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addTag($tagName)
    {
        $sql = "INSERT INTO tags (name)  
                values (:tag_name)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":tag_name", $tagName);
        $statement->execute();
        return $this->connection->lastInsertId();
    }

    public function readTag($tagName)
    {
        $sql = "SELECT id
                FROM tags
                WHERE name = :tag_name";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":tag_name", $tagName);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function addTagToBlog($tagId, $blogId)
    {
        $sql = "INSERT INTO blog_tags (tag_id, blog_id)  
                values (:tag_id, :blog_id)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":tag_id", $tagId, PDO::PARAM_INT);
        $statement->bindParam(":blog_id", $blogId, PDO::PARAM_INT);
        $statement->execute();
    }

    public function deleteBlogTags($blogId)
    {
        $sql = "DELETE FROM blog_tags  
                WHERE blog_id = :blog_id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":blog_id", $blogId, PDO::PARAM_INT);
        $statement->execute();
    }

    public function readBlogTagIds($blogId)
    {
        $sql = "SELECT tags.id 
                FROM tags
                JOIN blog_tags ON tag_id = tags.id
                WHERE blog_id = :blog_id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":blog_id", $blogId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function blogTagExist($tagId)
    {
        $sql = "SELECT blog_id 
                FROM blog_tags
                WHERE tag_id = :tag_id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":tag_id", $tagId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteTag($tagId)
    {
        $sql = "DELETE FROM tags  
                WHERE id = :tag_id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":tag_id", $tagId, PDO::PARAM_INT);
        $statement->execute();
    }
}
