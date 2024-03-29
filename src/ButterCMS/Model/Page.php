<?php

namespace ButterCMS\Model;

class Page extends Model
{
    protected $slug;
    protected $page_type;
    protected $published;
    protected $updated;
    protected $fields;

    public function getField($fieldName, $default = null)
    {
        return isset($this->fields[$fieldName]) ? $this->fields[$fieldName] : $default;
    }
}
