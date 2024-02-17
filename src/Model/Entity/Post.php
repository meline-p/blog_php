<?php

namespace App\Model\Entity;

/**
 * Class representing Post entity.
 */
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

    /**
     * Populate the Post object from a database row.
     *
     * @param  mixed $row Database row representing a post
     * @return void
     */
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

        $this->user_surname = $row['user_surname'] ?? '';
    }

    /**
     * Initialize a new post with provided data.
     *
     * @param  mixed $title         Title of the post
     * @param  mixed $chapo         Brief summary or introduction of the post
     * @param  mixed $content       Content of the post
     * @param  mixed $user_id       User ID associated with the post
     * @param  mixed $isPublished   Status of the post (published or not)
     * @return void
     */
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

    /**
     * Update the post with new data.
     *
     * @param  mixed $title         New title of the post
     * @param  mixed $chapo         New brief summary or introduction of the post
     * @param  mixed $content       New content of the post
     * @param  mixed $user_id       New user ID associated with the post
     * @param  mixed $isPublished   New status of the post (published or not)
     * @return void
     */
    public function update($title, $chapo, $content, $user_id, $isPublished)
    {
        $this->title = $title;
        $this->chapo = $chapo;
        $this->content = $content;
        $this->user_id = $user_id;
        $this->is_published = $isPublished;
        $this->updated_at = new \DateTime();
    }

    /**
     * Mark the post as deleted.
     *
     * @param  mixed $id            Post ID
     * @param  mixed $isPublished   Status of the post (published or not)
     * @return void
     */
    public function delete($id, $isPublished)
    {
        $this->id = $id;
        $this->is_published = $isPublished;
        $this->updated_at = new \DateTime();
        $this->deleted_at = new \DateTime();
    }

    /**
     * Restore a deleted post.
     *
     * @param  mixed $id Post ID
     * @return void
     */
    public function restore($id)
    {
        $this->id = $id;
        $this->updated_at = new \DateTime();
        $this->deleted_at = null;
    }
}
