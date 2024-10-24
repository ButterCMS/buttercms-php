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

