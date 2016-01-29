<?php

namespace SocialiteProviders\Slack;

use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    protected $scopes = [];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            'https://slack.com/oauth/authorize', $state
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://slack.com/api/oauth.access';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(
            'https://slack.com/api/oauth.access?token='.$token
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
        ]);
    }

    /**
     * Get the account ID of the current user.
     *
     * @param string $token
     *
     * @return string
     */
    protected function getUserId($token)
    {
        $response = $this->getHttpClient()->get(
            'https://slack.com/api/auth.test?token='.$token
        );

        $response = json_decode($response->getBody()->getContents(), true);

        return $response['user_id'];
    }
}
