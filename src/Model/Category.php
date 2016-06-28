<?php

namespace ButterCMS\Model;

class Category extends Model
{
    protected
        $slug,
        $name;

    public function getSlug()
    {
        return $this->slug;
    }

    public function getName()
    {
        return $this->name;
    }
}
