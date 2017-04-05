<?php

namespace App\Acme\Socialite;

use GuzzleHttp\ClientInterface;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class GoogleCustomProvider extends AbstractProvider implements ProviderInterface {
    /**
     * The separating character for the requested scopes.
     *
     * @var string
     */
    protected $scopeSeparator = ' ';

    /**
     * The scopes being requested.
     *
     * @var array
     */
    protected $scopes = [
        'https://www.googleapis.com/auth/plus.me',
        'https://www.googleapis.com/auth/plus.login',
        'https://www.googleapis.com/auth/plus.profile.emails.read',
        'https://www.googleapis.com/auth/drive.readonly'
    ];

    /**
     * Get the access token for the given code.
     *
     * @param  string $code
     * @return string
     */
    public function getAccessToken( $code )
    {
        $postKey = (version_compare( ClientInterface::VERSION, '6' ) === 1) ? 'form_params' : 'body';


        $response = $this->getHttpClient()->post( $this->getTokenUrl(), [
            'headers' => ['Authorization' => 'Bearer '],// . base64_encode($this->clientId . ':' . $this->clientSecret)],
            $postKey => $this->getTokenFields( $code ),
        ] );

//        this method is responsible to get only access token 
//        instead of getting full json token,
//        so this method is causing problem in original google provider class
//        so we disabled this method call and return full token instead of just access token
//        return $this->parseAccessToken();


        //return full token info instead of only access token token string
        //return $this->parseAccessToken($response->getBody());
        return json_decode( $response->getBody(), true );
         
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://accounts.google.com/o/oauth2/token';
    }

    /**
     * Get the POST fields for the token request.
     *
     * @param  string $code
     * @return array
     */
    protected function getTokenFields( $code )
    {
        return array_add(
            parent::getTokenFields( $code ), 'grant_type', 'authorization_code'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl( $state )
    {
        /*
         * added approval_promt=force && access_type=offline for getting refresh token in case session is not ended
         */
        $this->parameters["approval_prompt"] = "force";
        $this->parameters["access_type"] = "offline";
        return $this->buildAuthUrlFromBase( 'https://accounts.google.com/o/oauth2/auth', $state );
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken( $token )
    {
        $response = $this->getHttpClient()->get( 'https://www.googleapis.com/plus/v1/people/me?', [
            'query' => [
                'prettyPrint' => 'false',
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,//added ['access_token'] to get only token string
            ],
        ] );

        return json_decode( $response->getBody(), true );
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject( array $user )
    {
        return ( new User )->setRaw( $user )->map( [
            'id' => $user['id'], 'nickname' => array_get( $user, 'nickname' ), 'name' => $user['displayName'],
            'email' => $user['emails'][0]['value'], 'avatar' => array_get( $user, 'image' )['url'],
        ] );
    }
}