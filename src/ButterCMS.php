<?php

namespace ButterCMS;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use ButterCMS\Model\Author;
use ButterCMS\Model\Category;
use ButterCMS\Model\Post;

class ButterCMS
{
    const
        API_ROOT_URL = 'https://api.buttercms.com/v2/';

    protected
        $authToken,
        $client;

    public function __construct($authToken)
    {
        $this->authToken = $authToken;

        $this->client = new Client();
    }

    protected function request($url, $params = [])
    {
        try {
            $params['auth_token'] = $this->authToken;
            $response = $this->client->get(self::API_ROOT_URL . $url, [
                'query' => $params
            ]);
        } catch (ClientException $e) {
            return false;
        }

        $responseString = $response->getBody()->getContents();
        $dataArray = json_decode($responseString, true);
        if (is_array($dataArray) && JSON_ERROR_NONE === json_last_error()) {
            return $dataArray;
        }

        return false;
    }

    ///////////////
    // Feeds
    ///////////////

    public function getFeed($type)
    {
        $feedData = $this->request('feeds/' . $type);
        if (empty($feedData['data'])) {
            return false;
        }

        return new \SimpleXMLElement($feedData['data']);
    }

    ///////////////
    // Authors
    ///////////////

    public function getAuthor($authorSlug)
    {
        $rawAuthor = $this->request('authors/' . $authorSlug);
        return new Author($rawAuthor['data']);
    }

    public function getAuthors($params = [])
    {
        $rawAuthors = $this->request('authors', $params);
        $authors = [];
        foreach ($rawAuthors['data'] as $rawAuthor) {
            $authors[] = new Author($rawAuthor);
        }
        return $authors;
    }

    ///////////////
    // Categories
    ///////////////

    public function getCategory($categorySlug)
    {
        $rawCategory = $this->request('categories/' . $categorySlug);
        return new Category($rawCategory['data']);
    }

    public function getCategories($params = [])
    {
        $rawCategories = $this->request('categories', $params);
        $categories = [];
        foreach ($rawCategories['data'] as $rawCategory) {
            $categories[] = new Category($rawCategory);
        }
        return $categories;
    }

    ///////////////
    // Posts
    ///////////////

    public function getPost($postSlug)
    {
        $rawPost = $this->request('posts/' . $postSlug);
        $post = new Post($rawPost['data']);
        $post->setMeta($rawPost['meta']);
        return $post;
    }

    public function getPosts($params = [])
    {
        $rawPosts = $this->request('posts', $params);
        $posts = [];
        foreach ($rawPosts['data'] as $rawPost) {
            $post = new Post($rawPost);
            $post->setMeta($rawPosts['meta']);
            $posts[] = $post;
        }
        return $posts;
    }

    public function searchPosts($query, $params = [])
    {
        $params['query'] = $query;
        $rawPosts = $this->request('search', $params);
        $posts = [];
        foreach ($rawPosts['data'] as $rawPost) {
            $post = new Post($rawPost);
            $post->setMeta($rawPosts['meta']);
            $posts[] = $post;
        }
        return $posts;
    }
}
