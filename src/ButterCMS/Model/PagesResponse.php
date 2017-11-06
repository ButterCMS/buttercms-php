<?php

namespace ButterCMS\Model;

class PagesResponse extends MetaResponse
{
    protected
        $pages;

    public function __construct(array $dataArray)
    {
        $this->pages = [];

        if (!empty($dataArray['data'])) {
            foreach ($dataArray['data'] as $pageData) {
                $this->pages[] = new Page($pageData);
            }
            unset($dataArray['data']);
        }

        parent::__construct($dataArray);
    }
}
