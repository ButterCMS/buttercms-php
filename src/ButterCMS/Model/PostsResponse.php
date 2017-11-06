<?php

namespace ButterCMS\Model;

class PostsResponse extends MetaResponse
{
    protected
        $posts;

    public function __construct(array $dataArray)
    {
        $this->posts = [];

        if (!empty($dataArray['data'])) {
            foreach ($dataArray['data'] as $postsData) {
                $this->posts[] = new Post($postsData);
            }
            unset($dataArray['data']);
        }

        parent::__construct($dataArray);
    }
}
