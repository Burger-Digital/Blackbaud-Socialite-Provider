<?php

namespace SocialiteProviders\Blackbaud;

use Laravel\Socialite\Two\InvalidStateException;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'BLACKBAUD';

    const URL = 'https://oauth2.sky.blackbaud.com';

    /**
     * {@inheritdoc}
     */
    protected $scopes = [''];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(self::URL . '/authorization', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return self::URL . '/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(self::URL . '/me', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'environment_id'       => $user['environment_id'],
            'environment_name'       => $user['environment_name'],
            'legal_entity_id'       => $user['legal_entity_name'],
            'user_id'       => $user['user_id'],
            'email'       => $user['email'],
            'user_id'       => $user['user_id'],
            'family_name'       => $user['family_name'],
            'given_name'       => $user['given_name'],
            'access_token'       => $user['access_token'],
            'token_type'       => $user['token_type'],
            'expires_in'       => $user['expires_in'],
            'refresh_token_expires_in'       => $user['refresh_token_expires_in'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function user()
    {
        if ($this->hasInvalidState()) {
            throw new InvalidStateException();
        }

        $response = $this->getAccessTokenResponse($this->getCode());
        $this->credentialsResponseBody = $response;

        $token = $this->parseAccessToken($response);

        $user = $this->mapUserToObject($this->credentialsResponseBody);

        if ($user instanceof User) {
            $user->setAccessTokenResponseBody($this->credentialsResponseBody);
        }

        return $user->setToken($token)
            ->setRefreshToken($this->parseRefreshToken($response))
            ->setExpiresIn($this->parseExpiresIn($response));
    }

}
