<?php

namespace ButterCMS\Model;

class Collection extends Model
{
    protected $key;
    protected $items;

    public function __construct(array $data)
    {
        $this->items = [];

        if (!empty($data['items'])) {
            foreach ($data['items'] as $item) {
                $this->items[] = new CollectionItem($item);
            }
            unset($data['items']);
        }

        parent::__construct($data);
    }
}
