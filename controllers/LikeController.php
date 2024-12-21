<?php

require_once __DIR__ . "/../models/Like.php";

class LikeController
{
    public function __construct()
    {
        if (!isset($_SESSION["id"])) {
            header("Location: home");
        }
    }

    public function likeOrUnlikePost()
    {
        $userId = $_SESSION["id"];
        $blogId = $_POST["id"];

        $likeModel = new Like();

        if ($likeModel->readBlogUserLikeStatus($blogId, $userId)) {
            $likeModel->unlikeBlog($blogId, $userId);
        } else {
            $likeModel->likeBlog($blogId, $userId);
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}