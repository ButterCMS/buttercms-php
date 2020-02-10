<?php

namespace ButterCMS\Model;

class Post extends Model
{
    protected
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
        $tags,
        $featured_image,
        $featured_image_alt;

    public function __construct(array $data)
    {
        if (!empty($data['author'])) {
            $this->author = new Author($data['author']);
            unset($data['author']);
        }

        if (!empty($data['categories'])) {
            $this->categories = [];
            foreach ($data['categories'] as $categoryData) {
                $this->categories[] = new Category($categoryData);
            }
            unset($data['categories']);
        }

        if (!empty($data['tags'])) {
            $this->tags = [];
            foreach ($data['tags'] as $tagData) {
                $this->tags[] = new Tag($tagData);
            }
            unset($data['tags']);
        }

        parent::__construct($data);
    }

    public function isPublished()
    {
        return 'published' === $this->status;
    }
}
