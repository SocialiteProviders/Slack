<?php
namespace SocialiteProviders\Slack;

use SocialiteProviders\Manager\SocialiteWasCalled;

class SlackExtendSocialite
{
    /**
     * Execute the provider.
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite(
            'slack', __NAMESPACE__.'\Provider'
        );
    }
}
