<?php

namespace ButterCMS\Model;

class Post extends Model
{
    protected
        $slug,
        $url,
        $published,
        $created,
        $status,
        $title,
        $body,
        $summary,
        $seo_title,
        $meta_description,
        // $author,
        // $categories,
        $featured_image;
}
