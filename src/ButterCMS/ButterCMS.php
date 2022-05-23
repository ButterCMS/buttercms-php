<?php

namespace ButterCMS;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use ButterCMS\Model\Author;
use ButterCMS\Model\Category;
use ButterCMS\Model\Tag;
use ButterCMS\Model\Page;
use ButterCMS\Model\PagesResponse;
use ButterCMS\Model\Post;
use ButterCMS\Model\PostResponse;
use ButterCMS\Model\PostsResponse;

class ButterCMS
{
    const
        VERSION = '2.4.0',
        API_ROOT_URL = 'https://api.buttercms.com/v2/';

    protected
        $authToken,
        $client;

    public function __construct($authToken)
    {
        $this->authToken = $authToken;

        $this->client = new Client([
            'headers' => [
                'X-Butter-Client' => 'PHP/' . self::VERSION,
                'Accept-Encoding' => 'gzip'
            ],
        ]);
    }

    protected function request($url, $params = [], $tryCount = 0)
    {
        // Guzzle uses http_build_query() which will convert boolean true to "1"
        // instead of "true" in the GET parameters
        array_walk($params, function (&$item) {
            if (is_bool($item)) {
                $item = true === $item ? "true" : "false";
            }
        });

        try {
            $params['auth_token'] = $this->authToken;
            $response = $this->client->get(self::API_ROOT_URL . $url, [
                'query' => $params,
            ]);
        } catch (BadResponseException $e) {
            $httpCode = (int)$e->getResponse()->getStatusCode();
            if ($tryCount < 1 && $httpCode !== 404) {
                return $this->request($url, $params, ++$tryCount);
            }

            throw $e;
        }

        $responseString = $response->getBody()->getContents();
        $dataArray = json_decode($responseString, true);
        if (is_array($dataArray) && JSON_ERROR_NONE === json_last_error()) {
            return $dataArray;
        }

        throw new \UnexpectedValueException('API response was invalid JSON: ' . $responseString);
    }

    ///////////////
    // Feeds
    ///////////////

    public function fetchFeed($type)
    {
        $feedData = $this->request('feeds/' . $type . '/');
        return new \SimpleXMLElement($feedData['data']);
    }

    ///////////////
    // Authors
    ///////////////

    public function fetchAuthor($authorSlug)
    {
        $rawAuthor = $this->request('authors/' . $authorSlug . '/');
        return new Author($rawAuthor['data']);
    }

    public function fetchAuthors(array $params = [])
    {
        $rawAuthors = $this->request('authors/', $params);
        $authors = [];
        foreach ($rawAuthors['data'] as $rawAuthor) {
            $authors[] = new Author($rawAuthor);
        }
        return $authors;
    }

    ///////////////
    // Categories
    ///////////////

    public function fetchCategory($categorySlug)
    {
        $rawCategory = $this->request('categories/' . $categorySlug . '/');
        return new Category($rawCategory['data']);
    }

    public function fetchCategories(array $params = [])
    {
        $rawCategories = $this->request('categories/', $params);
        $categories = [];
        foreach ($rawCategories['data'] as $rawCategory) {
            $categories[] = new Category($rawCategory);
        }
        return $categories;
    }

    ///////////////
    // Tags
    ///////////////

    public function fetchTag($tagSlug)
    {
        $rawTag = $this->request('tags/' . $tagSlug . '/');
        return new Tag($rawTag['data']);
    }

    public function fetchTags(array $params = [])
    {
        $rawTags = $this->request('tags/', $params);
        $tags = [];
        foreach ($rawTags['data'] as $rawTag) {
            $tags[] = new Tag($rawTag);
        }
        return $tags;
    }

    ///////////////
    // Pages
    ///////////////

    public function fetchPage($type, $slug, array $params = [])
    {
        $rawPage = $this->request('pages/' . $type . '/' . $slug . '/', $params);
        return new Page($rawPage['data']);
    }

    public function fetchPages($type, array $params = [])
    {
        $rawPages = $this->request('pages/' . $type . '/', $params);
        return new PagesResponse($rawPages);
    }

    ///////////////
    // Posts
    ///////////////

    public function fetchPost($postSlug)
    {
        $rawPost = $this->request('posts/' . $postSlug . '/');
        return new PostResponse($rawPost);
    }

    public function fetchPosts(array $params = [])
    {
        $rawPosts = $this->request('posts/', $params);
        return new PostsResponse($rawPosts);
    }

    public function searchPosts($query, array $params = [])
    {
        $params['query'] = $query;
        $rawPosts = $this->request('search/', $params);
        return new PostsResponse($rawPosts);
    }

    ///////////////
    // Content Fields
    ///////////////

    public function fetchContentFields(array $keys, array $options = [])
    {
        $params = ['keys' => implode(',', $keys)];
        $params = array_merge($params, $options);
        $rawContentFields = $this->request('content/', $params);
        return isset($rawContentFields['data']) ? $rawContentFields['data'] : false;
    }
}
