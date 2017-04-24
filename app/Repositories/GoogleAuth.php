<?php

namespace App\Repositories;

use \Google_Client; 
use \Google_Service_Drive;
use \Google_Service_Gmail;

class GoogleAuth
{
    protected $client;

    public function __construct(Google_Client $googleClient = null)
    {
        $this->client = $googleClient;

        if($this->client)
        {
            $this->client->setAuthConfig(env('GOOGLE_API_KEY'));
            $this->client->setClientId('626458586196-be1qrn1h04rf2aqtorcj329upuf50isl.apps.googleusercontent.com');
            $this->client->setClientSecret('HunF8ircCI3YQCa39SLW926u');
            $this->client->setRedirectUri(url('login/google/callback'));
            $this->client->addScope(Google_Service_Drive::DRIVE_READONLY);
            $this->client->addScope('profile');
            $this->client->addScope('email');
        }
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['access_token']);
    }

    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    public function checkRedirectCode(){
        if(isset($_GET['code']))
        {
            $this->client->authenticate($_GET['code']);

            $this->setToken($this->client->getAccessToken());

            return true;
        }
        return false;
    }

    public function setToken($token)
    {
        $_SESSION['access_token'] = $token;

        $this->client->setAccessToken($token);
    }

    public function logout()
    {
        unset($_SESSION['access_token']);
    }

    public function getProfile()
    {
        if(isset($_SESSION['access_token']))
        {
            $this->client->setAccessToken($_SESSION['access_token']);
        }

        if ($this->client->isAccessTokenExpired()) {
            $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            $this->setToken($this->client->getAccessToken());
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$_SESSION['access_token']['access_token']
        ));

        $result = curl_exec($curl);
        
        return json_decode($result, true);
    }

    public function getDrive($id)
    {
        if(isset($_SESSION['access_token']))
        {
            $this->client->setAccessToken($_SESSION['access_token']);
        }

        if ($this->client->isAccessTokenExpired()) {
            $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            $this->setToken($this->client->getAccessToken());
        }

        $service = new Google_Service_Drive($this->client);

        $fileId = $id;
        $response = $service->files->export($fileId, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', array('alt' => 'media'));
        $content = $response->getBody()->getContents();
        
        return $content;
    }
}