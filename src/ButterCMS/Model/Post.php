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

    public function getSlug()
    {
        return $this->slug;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getPublished()
    {
        return $this->published;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getScheduled()
    {
        return $this->scheduled;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getSummary()
    {
        return $this->summary;
    }

    public function getSeoTitle()
    {
        return $this->seo_title;
    }

    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function getFeaturedImage()
    {
        return $this->featured_image;
    }

    public function getFeaturedImageAlt()
    {
        return $this->featured_image_alt;
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

