<?php

namespace SocialiteProviders\Blackbaud;

use SocialiteProviders\Manager\SocialiteWasCalled;

class BlackbaudExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param  \SocialiteProviders\Manager\SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('blackbaud', Provider::class);
    }
}
