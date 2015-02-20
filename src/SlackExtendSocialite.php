<?php
namespace SocialiteProviders\Slack;

use SocialiteProviders\Manager\SocialiteWasCalled;

class SlackExtendSocialite
{
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('slack', __NAMESPACE__.'\Provider');
    }
}
