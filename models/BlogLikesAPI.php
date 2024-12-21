<?php

require_once __DIR__ . "/Model.php";

class BlogLikesAPI extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getBlogLikes($blog_id)
    {
        $sql = "SELECT users.id AS user_id, first_name, last_name, name_as_author, email, created_time AS like_time
                FROM likes 
                JOIN users ON id = user_id 
                WHERE blog_id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$blog_id]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
