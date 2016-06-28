<?php

namespace ButterCMS\Model;

class Category extends Model
{
    protected
        $name,
        $slug;

    public function getName()
    {
        return $this->name;
    }

    public function getSlug()
    {
        return $this->slug;
    }
}
