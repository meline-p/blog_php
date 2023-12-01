<?php

namespace App\Model\Entity;

class Post
{
    // properties
    public $id;
    public $user_id;
    public $title;
    public $chapo;
    public $content;
    public $is_published;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    public $user_surname;

    // getters and setters

    public function fromSql($row)
    {
        $this->id = $row['id'];
        $this->user_id = $row['user_id'];
        $this->title = $row['title'];
        $this->chapo = $row['chapo'];
        $this->content = $row['content'];
        $this->is_published = $row['is_published'];
        $this->created_at = $row['created_at'];
        $this->updated_at = $row['updated_at'];
        $this->deleted_at = $row['deleted_at'];

        $this->user_surname = $row['user_surname'];
    }

    public function init($title, $chapo, $content, $user_id, $isPublished)
    {
        $this->title = $title;
        $this->chapo = $chapo;
        $this->content = $content;
        $this->user_id = $user_id;
        $this->is_published = $isPublished;
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    public function update($title, $chapo, $content, $user_id, $isPublished)
    {
        $this->title = $title;
        $this->chapo = $chapo;
        $this->content = $content;
        $this->user_id = $user_id;
        $this->is_published = $isPublished;
        $this->updated_at = new \DateTime();
    }

    public function delete($id, $isPublished)
    {
        $this->id = $id;
        $this->is_published = $isPublished;
        $this->updated_at = new \DateTime();
        $this->deleted_at = new \DateTime();
    }

    public function restore($id)
    {
        $this->id = $id;
        $this->updated_at = new \DateTime();
        $this->deleted_at = null;
    }
}
