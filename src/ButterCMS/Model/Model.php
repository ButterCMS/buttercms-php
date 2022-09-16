<?php

namespace ButterCMS\Model;

use JsonSerializable;

class Model implements JsonSerializable
{
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function __call($name, $arguments)
    {
        if (0 === strpos($name, 'get')) {
            // Convert getSomeDataMember() to some_data_member
            $propertyName = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $name));
            $propertyName = substr($propertyName, 4);

            if (!property_exists($this, $propertyName)) {
                throw new \Exception('Method ' . $name . '() does not exist on class ' . get_class($this));
            }

            return $this->$propertyName;
        }
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
