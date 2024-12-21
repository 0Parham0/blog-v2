<?php

require_once __DIR__ . "/../models/Blog.php";
require_once __DIR__ . "/../models/Tag.php";
require_once __DIR__ . "/../models/Like.php";
require_once __DIR__ . "/Traits/TagTrait.php";

class BlogController
{
    use TagTrait;

    public function __construct()
    {
        if (!isset($_SESSION["id"])) {
            header("Location: home");
        }
    }

    public function showBlogForm()
    {
        if (isset($_POST["blogId"])) {
            $blogId = $_POST["blogId"];

            $blogModel = new Blog();
            $blog = $blogModel->readBlogWithId($blogId);
            $title = $blog["title"];
            $description = $blog["description"];

            $tagModel = new Tag();
            $tagsArray = array_column($tagModel->readBlogTagNames($blogId), "name");
            $tags = count($tagsArray) > 0 ? implode(", ", $tagsArray) : "";
        }
        require_once __DIR__ . "/../views/writeBlog.php";
    }

    public function writeOrEditBlog()
    {
        $title = isset($_POST["title"]) ? $_POST["title"] : "";
        $description = isset($_POST["description"]) ? $_POST["description"] : "";
        $tags = isset($_POST["tags"]) ? $_POST["tags"] : "";
        $blogId = isset($_POST["blogId"]) ? $_POST["blogId"] : "";

        $errors = self::blogValidation($title, $description, $tags);
        if (count($errors) > 0) {
            require_once __DIR__ . "/../views/writeBlog.php";
        } else {
            $blogModel = new Blog();
            $tagModel = new Tag();

            if ($blogId) {
                $blogModel->updateBlog($title, $description, $blogId);

                $this->deleteOldTagAndRelationWithBlog($blogId);
            } else {
                $blogId = (int)$blogModel->writeBlog($title, $description, $_SESSION["id"]);
            }

            $tags = explode(",", $tags);
            foreach ($tags as $tag) {
                $tag = trim($tag);
                if ($tagRow = $tagModel->readTag($tag)) {
                    $tagId = $tagRow["id"];
                } else if ($tag !=  "") {
                    $tagId = $tagModel->addTag($tag);
                }

                if (isset($tagId)) {
                    $tagModel->addTagToBlog($tagId, $blogId);
                }
            }


            header("Location: dashboard");
        }
    }

    public function deleteBlog()
    {
        if (isset($_POST["blogId"])) {
            $blogId = $_POST["blogId"];

            $likeModel = new Like();
            $likeModel->deleteBlogLikes($blogId);

            $this->deleteOldTagAndRelationWithBlog($blogId);

            $blogModel = new Blog();
            $blogModel->deleteBlog($blogId);
        }
        header("Location: dashboard");
    }

    private function blogValidation($title, $description, $tags)
    {
        $errors = [];

        $tags = explode(",", $tags);
        foreach ($tags as $tag) {
            $tag = trim($tag);
            
            if (!preg_match('/^[a-zA-Z][a-zA-Z0-9\s\_]*$/', $tag) && !empty($tag)) {
                array_push($errors, "$tag is not in the right format");
            } else if (strlen($tag) > 50) {
                array_push($errors, "$tag cannot exceed 50 characters");
            }
        }

        if (!preg_match('/^[a-zA-Z0-9\s\-_,\.!?]+$/', $title)) {
            array_push($errors, "title is not in the right format");
        } else if (strlen($title) > 80) {
            array_push($errors,  "title cannot exceed 80 characters");
        }

        if (!preg_match('/^[a-zA-Z0-9\s\-_,\.!?]+$/', $description)) {
            array_push($errors,  "description is not in the right format");
        } else if (strlen($description) > 65535) {
            array_push($errors,  "description cannot exceed 65535 characters");
        }

        return $errors;
    }
}