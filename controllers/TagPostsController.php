<?php

// .../TagPostsAPI

require_once __DIR__ . "/../models/TagPostsAPI.php";

class TagPostsController
{
    public function getTagPosts()
    {
        $tagPosts = new TagPostsAPI();
        $tags = $tagPosts->getTagPosts();

        $result = ["tags" => $tags];

        require_once __DIR__ . "/../views/apiResult.php";
    }
}
