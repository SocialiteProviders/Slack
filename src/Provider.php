<?php
namespace SocialiteProviders\Slack;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class Provider extends AbstractProvider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    protected $scopes = ['read'];

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
            'https://slack.com/api/users.info?token='.$token.'&user='.$this->getUserId($token)
        );

        return json_decode($response->getBody(), true)['user'];
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['id'], 'nickname' => $user['name'],
            'name' => $user['profile']['real_name'],
            'email' => $user['profile']['email'],
            'avatar' => $user['profile']['image_192'],
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

        $response = json_decode($response->getBody(), true);

        return $response['user_id'];
    }
}
