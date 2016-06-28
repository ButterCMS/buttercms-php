<?php

namespace ButterCMS;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use ButterCMS\Model\Category;

class ButterCMS
{
    const
        API_ROOT_URL = 'https://api.buttercms.com/v2/';

    protected
        $authToken;

    public function __construct($authToken)
    {
        $this->authToken = $authToken;
    }

    protected function request($url)
    {
        $client = new Client();
        try {
            $response = $client->get(self::API_ROOT_URL . $url, [
                'query' => [
                    'auth_token' => $this->authToken
                ]
            ]);
        } catch (ClientException $e) {
            var_dump($e->getMessage());
            return false;
        }

        $responseString = $response->getBody()->getContents();
        return json_decode($responseString, true);
    }

    public function getCategories()
    {
        $rawCategories = $this->request('categories');
        $categories = [];
        foreach ($rawCategories['data'] as $rawCategory) {
            $categories[] = new Category($rawCategory);
        }
        return $categories;
    }
}
