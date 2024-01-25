<?php

namespace Entity;

class Post
{
    // properties
    private $id;
    private $user_id;
    private $title;
    private $chapo;
    private $content;
    private $is_published;
    private $created_at;
    private $updated_at;
    private $deleted_at;

    // getters and setters

    // id
    public function setPostId($id)
    {
        $this->id = $id;
    }

    public function getPostId()
    {
        return $this->id;
    }

    // title
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
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

    // chapo
    public function setChapo($chapo)
    {
        $this->chapo = $chapo;
    }

    public function getChapo()
    {
        return $this->chapo;
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

    // is_published
    public function setIsPublished($is_published)
    {
        $this->is_published = $is_published;
    }

    public function getIsPublished()
    {
        return $this->is_published;
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

    //updated_at
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
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
