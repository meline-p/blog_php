<?php

namespace App\Model\Entity;

class Comment
{
    // properties
    public $id;
    public $user_id;
    public $post_id;
    public $content;
    public $is_enabled;
    public $created_at;
    public $deleted_at;

    public $user_surname;
    public $post_title;

    // getters and setters
    public function fromSql($row)
    {
        $this->id = $row['id'];
        $this->user_id = $row['user_id'];
        $this->post_id = $row['post_id'];
        $this->content = $row['content'];
        $this->is_enabled = $row['is_enabled'];
        $this->created_at = $row['created_at'];
        $this->deleted_at = $row['deleted_at'];

        $this->user_surname = $row['user_surname'];
        $this->post_title = $row['post_title'];
    }

    public function init($user_id, $post_id, $content, $is_enabled)
    {
        $this->user_id = $user_id;
        $this->post_id = $post_id;
        $this->content = $content;
        $this->is_enabled = $is_enabled;
        $this->created_at = new \DateTime();
    }

    public function confirm($id, $is_enabled)
    {
        $this->id = $id;
        $this->is_enabled = $is_enabled;
        $this->deleted_at = null;
    }

    public function delete($id, $is_enabled)
    {
        $this->id = $id;
        $this->is_enabled = $is_enabled;
        $this->deleted_at = new \DateTime();
    }

    // // id
    // public function setCommentId($id)
    // {
    //     $this->id = $id;
    // }

    // public function getCommentId()
    // {
    //     return $this->id;
    // }

    // // post_id
    // public function setPostId($post_id)
    // {
    //     $this->post_id = $post_id;
    // }

    // public function getPostId()
    // {
    //     return $this->post_id;
    // }

    // // content
    // public function setContent($content)
    // {
    //     $this->content = $content;
    // }

    // public function getContent()
    // {
    //     return $this->content;
    // }

    // // author
    // public function setAuthor($user_id)
    // {
    //     $this->user_id = $user_id;
    // }

    // public function getAuthor()
    // {
    //     return $this->user_id;
    // }

    // // is_enabled
    // public function setIsEnabled($is_enabled)
    // {
    //     $this->is_enabled = $is_enabled;
    // }

    // public function getIsEnabled()
    // {
    //     return $this->is_enabled;
    // }

    // // created_at
    // public function setCreatedAt($created_at)
    // {
    //     $this->created_at = $created_at;
    // }

    // public function getCreatedAt()
    // {
    //     return $this->created_at;
    // }

    // //deleted_at
    // public function setDeletedAt($deleted_at)
    // {
    //     $this->deleted_at = $deleted_at;
    // }

    // public function getDeletedAt()
    // {
    //     return $this->deleted_at;
    // }
}
