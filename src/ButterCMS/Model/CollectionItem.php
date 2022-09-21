<?php

namespace ButterCMS\Model;

class CollectionItem extends Model
{
    protected $id;
    protected $fields;

    public function __construct(array $data)
    {
        if (!empty($data['meta'])) {
            foreach ($data['meta'] as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
            unset($data['meta']);
        }

        $this->fields = $data;
    }

    public function getField($fieldName, $default = null)
    {
        return isset($this->fields[$fieldName]) ? $this->fields[$fieldName] : $default;
    }
}
