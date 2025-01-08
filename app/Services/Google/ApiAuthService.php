<?php

namespace App\Services\Google;

use Google\Client;

class ApiAuthService
{
    /**
     * @throws \Google\Exception
     */
    public function getAccessToken(): string
    {
        $client = new Client();
        $serviceAccountKeyPath = env('GOOGLE_APPLICATION_CREDENTIALS');
        $client->setAuthConfig($serviceAccountKeyPath);
        $client->addScope('https://www.googleapis.com/auth/cloud-platform');
        $client->fetchAccessTokenWithAssertion();

        // todo - cache, refresh, etc
        $accessToken = $client->getAccessToken();

        return $accessToken['access_token'];
    }
}
