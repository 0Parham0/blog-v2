<?php

require_once __DIR__ . "/../models/Blog.php";
require_once __DIR__ . "/../models/Tag.php";
require_once __DIR__ . "/../models/Like.php";
require_once __DIR__ . "/Traits/LikeTrait.php";
require_once __DIR__ . "/Traits/TagTrait.php";
require_once __DIR__ . "/Traits/SearchTrait.php";

class DashboardController
{
    use LikeTrait;
    use TagTrait;
    use SearchTrait;

    public function __construct()
    {
        if (!isset($_SESSION["id"])) {
            header("Location: home");
        }
    }

    public function readBlogs()
    {
        $searchText = isset($_GET["searchText"]) && $_GET["searchText"] != null ? $_GET["searchText"] : null;
        $searchBetween = isset($_GET["searchBetween"]) ? $this->searchBetweenValidation($_GET["searchBetween"]) : null;
        $userId = isset($_SESSION["id"]) ? $_SESSION["id"] : null;

        $blogModel = new Blog();
        $tagModel = new Tag();
        $likeModel = new Like();

        if (!isset($searchText) && !isset($userId)) {
            $blogs = $blogModel->readAll();
        } else if (!isset($searchText) && isset($userId)) {
            $blogs = $blogModel->readWithUserId($userId);
            $this->blogsLikeStatus($blogs, $userId);
        } else if (isset($searchText) && !isset($userId)) {
            if ($searchBetween == "all") {
                $blogs = $blogModel->readWithSearchBetweenAll($searchText);
            } else {
                $blogs = $blogModel->readWithSearch($searchBetween, $searchText);
            }
        } else {
            if ($searchBetween == "all") {
                $blogs = $blogModel->readWithUserIdAndSearchBetweenAll($userId, $searchText);
            } else {
                $blogs = $blogModel->readWithUserIdAndSearch($userId, $searchBetween, $searchText);
            }
            $this->blogsLikeStatus($blogs, $userId);
        }

        foreach ($blogs as &$blog) {
            $this->blogTagString($blog);

            $this->blogLikeCount($blog);
        }

        self::showBlogs($blogs);
    }


    public function showBlogs($blogs)
    {
        require_once __DIR__ . "/../views/dashboard.php";
    }
}