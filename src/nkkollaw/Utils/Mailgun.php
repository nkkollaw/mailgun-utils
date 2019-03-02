<?php
namespace nkkollaw\Utils;

class Mailgun {
    // get all events taking care of pagination
    public function getEvents()
    {
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
    public function getBounces() {
        throw new \Exception('not implemented');
    }
}