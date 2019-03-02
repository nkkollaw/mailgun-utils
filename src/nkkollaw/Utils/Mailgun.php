<?php
namespace nkkollaw\Utils;

class Mailgun {
    private $_BASE_URL = '';
    private $_API_KEY = '';

    public static function setBaseUrl($url) {
        self::$_BASE_URL = $url;
    }
    public static function getBaseUrl() {
        return self::$_BASE_URL;
    }

    public static function setApiKey($key) {
        self::$_API_KEY = $key;
    }
    public static function getApiKey() {
        return self::$_API_KEY;
    }

    // get all events taking care of pagination
    public static function getEvents()
    {
        if (!self::getBaseUrl()) {
            throw new \Exception('must set base URL');
        }
        if (!self::getApiKey()) {
            throw new \Exception('must set API key');
        }

        // pagination is not handled in class, so call "manually"
        $endpoint = MAILGUN_API_URL . '/events';

        $response = $client->request('GET', $endpoint, [
            'auth' => ['api', MAILGUN_API_KEY]
        ]);
        if (!$response) {
            throw new \Exception('did NOT get API content');
        }
        $response_json = json_decode($response->getBody(), false);
        if (!$response_json) {
            throw new \Exception('unable to parse JSON');
        }

        $events = $response_json->items;

        // get others
        while (count($response_json->items) > 0) {
            $endpoint = $response_json->paging->next;

            $response = $client->request('GET', $endpoint, [
                'auth' => ['api', MAILGUN_API_KEY]
            ]);
            if (!$response) {
                throw new \Exception('did NOT get API content');
            }
            $response_json = json_decode($response->getBody(), false);
            if (!$response_json) {
                throw new \Exception('unable to parse JSON');
            }

            $events = array_merge($events, $response_json->items);
        }

    }

    // get all bounces taking care of pagination
    public static function getBounces() {
        throw new \Exception('not implemented');
    }
}