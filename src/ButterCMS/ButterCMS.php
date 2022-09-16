<?php

namespace ButterCMS;

use ButterCMS\Model\Author;
use ButterCMS\Model\Category;
use ButterCMS\Model\CollectionsResponse;
use ButterCMS\Model\Page;
use ButterCMS\Model\PagesResponse;
use ButterCMS\Model\Post;
use ButterCMS\Model\PostResponse;
use ButterCMS\Model\PostsResponse;
use ButterCMS\Model\Tag;
use ButterCMS\Model\WriteResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class ButterCMS
{
    protected const VERSION = '2.4.0';
    protected const API_ROOT_URL = 'https://api.buttercms.com/v2/';

    protected $maxRetryCount = 1;
    protected $readAuthToken;
    protected $readClient;
    protected $writeAuthToken;
    protected $writeClient;

    public function __construct($readAuthToken, $writeAuthToken = null)
    {
        $defaultClientHeaders = [
            'X-Butter-Client' => 'PHP/' . self::VERSION,
            'Accept-Encoding' => 'gzip',
        ];

        $this->readAuthToken = $readAuthToken;
        $this->readClient = new Client([
            'headers' => $defaultClientHeaders,
        ]);

        if ($writeAuthToken) {
            $this->writeClient = new Client([
                'headers' => array_merge($defaultClientHeaders, [
                    'Authorization' => 'Token ' . ($this->writeAuthToken = $writeAuthToken),
                ]),
            ]);
        }
    }

    protected function request(string $method, $url, $query = [], $data = [], $tryCount = 0)
    {
        $method = strtolower($method);

        // Guzzle uses http_build_query() which will convert boolean true to "1"
        // instead of "true" in the GET parameters
        array_walk($query, function (&$item) {
            if (is_bool($item)) {
                $item = true === $item ? "true" : "false";
            }
        });

        if ($method == 'get') {
            $query['auth_token'] = $this->readAuthToken;
            $client = $this->readClient;
        } else {
            if (!$client = $this->writeClient) {
                throw new \BadMethodCallException(
                    'Write operation attempted without appropriate configuration. ' .
                    'Did you provide a write-enabled token?'
                );
            }
        }

        try {
            $options = array_filter([
                'query' => $query,
                'json' => $data,
            ]);
            $response = $client->$method(self::API_ROOT_URL . $url, $options);
        } catch (BadResponseException $e) {
            $httpCode = (int)$e->getResponse()->getStatusCode();
            if ($tryCount < $this->maxRetryCount && $httpCode !== 404) {
                return $this->request($method, $url, $query, $data, ++$tryCount);
            }

            throw $e;
        }

        $responseString = $response->getBody()->getContents();

        if ($method == 'delete') {
            return true;
        }

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
        $feedData = $this->request('GET', 'feeds/' . $type . '/');
        return new \SimpleXMLElement($feedData['data']);
    }

    ///////////////
    // Authors
    ///////////////

    public function fetchAuthor($authorSlug)
    {
        $rawAuthor = $this->request('GET', 'authors/' . $authorSlug . '/');
        return new Author($rawAuthor['data']);
    }

    public function fetchAuthors(array $params = [])
    {
        $rawAuthors = $this->request('GET', 'authors/', $params);
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
        $rawCategory = $this->request('GET', 'categories/' . $categorySlug . '/');
        return new Category($rawCategory['data']);
    }

    public function fetchCategories(array $params = [])
    {
        $rawCategories = $this->request('GET', 'categories/', $params);
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
        $rawTag = $this->request('GET', 'tags/' . $tagSlug . '/');
        return new Tag($rawTag['data']);
    }

    public function fetchTags(array $params = [])
    {
        $rawTags = $this->request('GET', 'tags/', $params);
        $tags = [];
        foreach ($rawTags['data'] as $rawTag) {
            $tags[] = new Tag($rawTag);
        }
        return $tags;
    }

    ///////////////
    // Pages
    ///////////////

    public function createPage(array $params = [])
    {
        $rawPage = $this->request('POST', 'pages/', [], $params);
        return new WriteResponse($rawPage);
    }

    public function fetchPage($type, $slug, array $params = [])
    {
        $rawPage = $this->request('GET', 'pages/' . $type . '/' . $slug . '/', $params);
        return new Page($rawPage['data']);
    }

    public function fetchPages($type, array $params = [])
    {
        $rawPages = $this->request('GET', 'pages/' . $type . '/', $params);
        return new PagesResponse($rawPages);
    }

    public function updatePage($slug, array $params = [])
    {
        $rawPage = $this->request('PATCH', 'pages/*/' . $slug . '/', [], $params);
        return new WriteResponse($rawPage);
    }

    ///////////////
    // Posts
    ///////////////

    public function createPost(array $params = [])
    {
        $rawPost = $this->request('POST', 'posts/', [], $params);
        return new WriteResponse($rawPost);
    }

    public function fetchPost($postSlug)
    {
        $rawPost = $this->request('GET', 'posts/' . $postSlug . '/');
        return new PostResponse($rawPost);
    }

    public function fetchPosts(array $params = [])
    {
        $rawPosts = $this->request('GET', 'posts/', $params);
        return new PostsResponse($rawPosts);
    }

    public function searchPosts($query, array $params = [])
    {
        $params['query'] = $query;
        $rawPosts = $this->request('GET', 'search/', $params);
        return new PostsResponse($rawPosts);
    }

    public function updatePost($postSlug, array $params = [])
    {
        $rawPost = $this->request('PATCH', 'posts/' . $postSlug . '/', [], $params);
        return new WriteResponse($rawPost);
    }

    /////////////////////////////////////////////
    // Collections (formerly "Content Fields")
    /////////////////////////////////////////////

    public function createCollectionItem($collectionKey, array $params = [])
    {
        $params['key'] = $collectionKey;
        $rawCollectionItem = $this->request('POST', 'content/', [], $params);
        return new WriteResponse($rawCollectionItem);
    }

    public function deleteCollectionItem($collectionKey, $id)
    {
        return $this->request('DELETE', 'content/' . $collectionKey . '/' . $id . '/');
    }

    public function fetchCollections(array $keys = [], array $options = [])
    {
        $params = ['keys' => implode(',', $keys)];
        $params = array_merge($params, $options);
        $rawCollections = $this->request('GET', 'content/', $params);
        return new CollectionsResponse($rawCollections);
    }

    public function updateCollectionItem($collectionKey, $id, array $params = [])
    {
        $rawCollectionItem = $this->request('PATCH', 'content/' . $collectionKey . '/' . $id . '/', [], $params);
        return new WriteResponse($rawCollectionItem);
    }

    /**
     * @deprecated Use fetchCollections instead.
     */
    public function fetchContentFields(array $keys, array $options = [])
    {
        $response = $this->fetchCollections($keys, $options);

        $legacyDataModel = [];

        foreach ($response->getCollections() as $collection) {
            $legacyDataModel[$collection->getKey()] = array_map(function ($item) {
                $itemModel = [];
                $itemModel['meta']['id'] = $item->getId();

                foreach ($item->getFields() as $key => $value) {
                    $itemModel[$key] = $value;
                }

                return $itemModel;
            }, $collection->getItems());
        }

        return $legacyDataModel ?: false;
    }
}
