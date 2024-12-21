<?php

require_once __DIR__ . "/../models/Blog.php";
require_once __DIR__ . "/../models/Tag.php";
require_once __DIR__ . "/../models/Like.php";
require_once __DIR__ . "/Traits/LikeTrait.php";
require_once __DIR__ . "/Traits/TagTrait.php";
require_once __DIR__ . "/Traits/SearchTrait.php";

class HomeController
{
    use LikeTrait;
    use TagTrait;
    use SearchTrait;

    public function readBlogs()
    {
        $searchText = isset($_GET["searchText"]) && $_GET["searchText"] != null ? $_GET["searchText"] : null;
        $searchBetween = isset($_GET["searchBetween"]) ? $this->searchBetweenValidation($_GET["searchBetween"]) : null;

        $blogModel = new Blog();
        $tagModel = new Tag();
        $likeModel = new Like();
        if (isset($searchBetween) && isset($searchText)) {
            if ($searchBetween == "all") {
                $blogs = $blogModel->readWithSearchBetweenAll($searchText);
            } else {
                $blogs = $blogModel->readWithSearch($searchBetween, $searchText);
            }
        } else {
            $blogs = $blogModel->readAll();
        }

        foreach ($blogs as &$blog) {
            $this->blogTagString($blog);

            $this->blogLikeCount($blog);

            if (isset($_SESSION["id"])) {
                if ($likeModel->readBlogUserLikeStatus($blog["blogId"], $_SESSION["id"])) {
                    $blog["likeStatus"] = "unlike";
                } else {
                    $blog["likeStatus"] = "like";
                }
            }
        }

        self::showBlogs($blogs);
    }

    public function showBlogs($blogs)
    {
        require_once __DIR__ . "/../views/home.php";
    }
}
