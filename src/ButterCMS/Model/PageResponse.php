<?php

namespace ButterCMS\Model;

class PageResponse extends Model
{
    protected
        $page;

    public function __construct(array $dataArray)
    {
        if (!empty($dataArray['data'])) {
            $this->page = new Page($dataArray['data']);
            unset($dataArray['data']);
        }

        parent::__construct($dataArray);
    }
}
