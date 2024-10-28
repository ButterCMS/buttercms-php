<?php

namespace ButterCMS\Model;

class Page extends Model
{
    protected $slug;
    protected $page_type;
    protected $published;
    protected $updated;
    protected $fields;
    protected $status;
    protected $scheduled;

    public function getSlug()
    {
        return $this->slug;
    }

    public function getPageType()
    {
        return $this->page_type;
    }

    public function getPublished()
    {
        return $this->published;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getScheduled()
    {
        return $this->scheduled;
    }

    public function getField($fieldName, $default = null)
    {
        return isset($this->fields[$fieldName]) ? $this->fields[$fieldName] : $default;
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

