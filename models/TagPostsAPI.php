<?php

require_once __DIR__ . "/Model.php";

class TagPostsAPI extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTagPosts()
    {
        $sql = "SELECT tags.name AS tag_name, COUNT(blog_tags.blog_id) AS blogs_count
                FROM tags
                JOIN blog_tags ON tags.id = blog_tags.tag_id
                GROUP BY tags.id";
        $statement = $this->connection->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
