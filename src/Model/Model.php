<?php

namespace ButterCMS\Model;

class Model
{
    public function __construct(array $data)
    {
        $class = get_class($this);
        foreach ($data as $key => $value) {
            if (property_exists($class, $key)) {
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

            $class = get_class($this);
            if (!property_exists($class, $propertyName)) {
                throw new \Exception('Method ' . $name . '() does not exist on class ' . $class);
            }

            return $this->$propertyName;
        }
    }
}
