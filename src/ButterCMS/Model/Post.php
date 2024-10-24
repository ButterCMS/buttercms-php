<?php

namespace ButterCMS\Model;

class Post extends Model
{
    protected $slug;
    protected $url;
    protected $published;
    protected $created;
    protected $status;
    protected $scheduled;
    protected $title;
    protected $body;
    protected $summary;
    protected $seo_title;
    protected $meta_description;
    protected $author;
    protected $categories;
    protected $tags;
    protected $featured_image;
    protected $featured_image_alt;

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

    public function isScheduled()
    {
        return 'scheduled' === $this->status;
    }

    public function isDraft()
    {
        return 'draft' === $this->status;
    }
}

