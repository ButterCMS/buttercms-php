<?php

namespace ButterCMS\Model;

class Page extends Model
{
    protected
        $slug,
        $page_type,
        $fields;

    public function getField($fieldName, $default = null)
    {
        return isset($this->fields[$fieldName]) ? $this->fields[$fieldName] : $default;
    }
}
