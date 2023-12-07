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
    public $post_content;

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
        $this->post_content = $row['post_content'];
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
}
