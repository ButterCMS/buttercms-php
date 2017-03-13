<?php

namespace ButterCMS;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use ButterCMS\Model\Author;
use ButterCMS\Model\Category;
use ButterCMS\Model\Tag;
use ButterCMS\Model\Post;
use ButterCMS\Model\PostResponse;
use ButterCMS\Model\PostsResponse;

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

    protected function request($url, $params = [], $tryCount = 0)
    {
        try {
            $params['auth_token'] = $this->authToken;
            $response = $this->client->get(self::API_ROOT_URL . $url, [
                'query' => $params
            ]);
        } catch (ClientException $e) {
            if ($tryCount < 1) {
                return $this->request($url, $params, ++$tryCount);
            }

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
        return $rawAuthor ? new Author($rawAuthor['data']) : false;
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
        return $rawCategory ? new Category($rawCategory['data']) : false;
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
    // Tags
    ///////////////

    public function getTag($tagSlug)
    {
        $rawTag = $this->request('tags/' . $tagSlug);
        return $rawTag ? new Tag($rawTag['data']) : false;
    }

    public function getTags($params = [])
    {
        $rawTags = $this->request('tags', $params);
        $tags = [];
        foreach ($rawTags['data'] as $rawTag) {
            $tags[] = new Tag($rawTag);
        }
        return $tags;
    }

    ///////////////
    // Posts
    ///////////////

    public function fetchPost($postSlug)
    {
        $rawPost = $this->request('posts/' . $postSlug);
        return $rawPost ? new PostResponse($rawPost) : false;
    }

    public function fetchPosts($params = [])
    {
        $rawPosts = $this->request('posts', $params);
        return new PostsResponse($rawPosts);
    }

    public function searchPosts($query, $params = [])
    {
        $params['query'] = $query;
        $rawPosts = $this->request('search', $params);
        return new PostsResponse($rawPosts);
    }

    ///////////////
    // Content Fields
    ///////////////

    public function getContentFields(array $keys)
    {
        $params = ['keys' => implode(',', $keys)];
        $rawContentFields = $this->request('content', $params);
        return isset($rawContentFields['data']) ? $rawContentFields['data'] : false;
    }
}
