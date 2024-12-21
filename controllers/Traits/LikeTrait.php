<?php

require_once __DIR__ . "/../../models/Like.php";

trait LikeTrait
{
    public function blogsLikeStatus(&$blogs, $userId){

        $likeModel = new Like();

        foreach ($blogs as &$blog) {
            if ($likeModel->readBlogUserLikeStatus($blog["blogId"], $userId)) {
                $blog["likeStatus"] = "unlike";
            } else {
                $blog["likeStatus"] = "like";
            }
        }
    }

    public function blogLikeCount(&$blog){
        $likeModel = new Like();

        $blog["likeCount"] = $likeModel->readBlogLikeCount($blog["blogId"])["likeCount"];
    }
}
