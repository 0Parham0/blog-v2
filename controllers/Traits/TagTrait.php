<?php

require_once __DIR__ . "/../../models/Blog.php";

trait TagTrait
{
    public function deleteOldTagAndRelationWithBlog($blogId)
    {
        $tagModel = new Tag();

        $oldTagIds = $tagModel->readBlogTagIds($blogId);
        $tagModel->deleteBlogTags($blogId);
        foreach ($oldTagIds as $oldTagId) {
            if (!$tagModel->blogTagExist($oldTagId["id"])) {
                $tagModel->deleteTag($oldTagId["id"]);
            }
        }
    }

    public function blogTagString(&$blog)
    {
        $tagModel = new Tag();

        $tagsArray = array_column($tagModel->readBlogTagNames($blog["blogId"]), "name");
        $blog["tags"] = count($tagsArray) > 0 ? "#" . implode(" #", $tagsArray) : "";
    }
}
