<?php

namespace ButterCMS\Model;

class PostResponse extends Model
{
    protected
        $post;

    public function __construct(array $dataArray)
    {
        if (!empty($dataArray['data'])) {
            $this->post = new Post($dataArray['data']);
            unset($dataArray['data']);
        }

        parent::__construct($dataArray);
    }
}
