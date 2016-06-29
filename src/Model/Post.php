<?php

namespace ButterCMS\Model;

class Post extends Model
{
    protected
        $meta, // Special cookie
        $slug,
        $url,
        $published,
        $created,
        $status,
        $title,
        $body,
        $summary,
        $seo_title,
        $meta_description,
        $author,
        $categories,
        $featured_image;

    public function __contruct(array $data)
    {
        if (!empty($data['author'])) {
            $this->author = new Author($data['author']);
            unset($data['author']);
        }

        if (!empty($data['categories'])) {
            $this->categories = [];
            foreach ($data['categories'] as $categoryData) {
                $author = new Category($categoryData);
            }
            unset($data['categories']);
        }

        parent::__construct($data);
    }

    public function setMeta($meta)
    {
        $this->meta = $meta;
    }

    public function isPublished()
    {
        return 'published' === $this->status;
    }
}
