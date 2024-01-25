<?php

namespace Entity;

class Comment
{
    // properties
    private $id;
    private $user_id;
    private $post_id;
    private $content;
    private $is_enabled;
    private $created_at;
    private $deleted_at;

    // getters and setters

    // id
    public function setCommentId($id)
    {
        $this->id = $id;
    }

    public function getCommentId()
    {
        return $this->id;
    }

    // post_id
    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
    }

    public function getPostId()
    {
        return $this->post_id;
    }

    // content
    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    // author
    public function setAuthor($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getAuthor()
    {
        return $this->user_id;
    }

    // is_enabled
    public function setIsEnabled($is_enabled)
    {
        $this->is_enabled = $is_enabled;
    }

    public function getIsEnabled()
    {
        return $this->is_enabled;
    }

    // created_at
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    //deleted_at
    public function setDeletedAt($deleted_at)
    {
        $this->deleted_at = $deleted_at;
    }

    public function getDeletedAt()
    {
        return $this->deleted_at;
    }
}
