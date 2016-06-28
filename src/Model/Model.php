<?php

namespace ButterCMS\Model;

class Model
{
    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}
