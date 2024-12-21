<?php

// .../BlogLikesAPI?blog_id=1

require_once __DIR__ . "/../models/BlogLikesAPI.php";

class BlogLikesController
{
    public function getBlogLikes()
    {
        if (isset($_GET["blog_id"])) {
            $blogId = $_GET["blog_id"];

            $blogLikes = new BlogLikesAPI();
            $users = $blogLikes->getBlogLikes($blogId);

            $result = ["users" => $users];

            require_once __DIR__ . "/../views/apiResult.php";
        }
    }
}
