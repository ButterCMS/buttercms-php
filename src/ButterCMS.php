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

    protected function request($url, $params = [])
    {
        $client = new Client();
        try {
            $params['auth_token'] = $this->authToken;
            $response = $client->get(self::API_ROOT_URL . $url, [
                'query' => $params
            ]);
        } catch (ClientException $e) {
            var_dump($e->getMessage());
            return false;
        }

        $responseString = $response->getBody()->getContents();
        return json_decode($responseString, true);
    }

    public function getAuthor($authorSlug)
    {
        $rawAuthor = $this->request('authors/' . $authorSlug);
        return new Author($rawAuthor['data']);
    }

    public function getAuthors()
    {
        $rawAuthorData = $this->request('authors');
        $authors = [];
        foreach ($rawAuthorData['data'] as $rawAuthor) {
            $authors[] = new Author($rawAuthor);
        }
        return $authors;
    }

    public function getCategory($categorySlug)
    {
        $rawCategory = $this->request('categories/' . $categorySlug);
        return new Category($rawCategory['data']);
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
