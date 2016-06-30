<?php

namespace ButterCMS\Model;

class PostsResponse extends Model
{
    protected
        $posts;

    public function __construct(array $dataArray)
    {
        if (!empty($dataArray['data'])) {
            $this->posts = [];
            foreach ($dataArray['data'] as $postsData) {
                $this->posts[] = new Post($postsData);
            }
            unset($dataArray['data']);
        }

        parent::__construct($dataArray);
    }
}
