<?php

namespace ButterCMS\Model;

class CollectionsResponse extends Model
{
    protected $collections;

    public function __construct(array $data)
    {
        $this->collections = [];

        if (!empty($data['data'])) {
            foreach ($data['data'] as $collection => $items) {
                $this->collections[] = new Collection([
                    'key' => $collection,
                    'items' => $items,
                ]);
            }
            unset($data['data']);
        }

        parent::__construct($data);
    }

    public function getCollection($collectionKey)
    {
        return array_values(array_filter($this->collections, function ($collection) use ($collectionKey) {
            return $collection->getKey() == $collectionKey;
        }))[0] ?? null;
    }
}
