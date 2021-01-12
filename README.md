# install
composer require burger-digital/blackbaud-socialite-provider

# register
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        'SocialiteProviders\Blackbaud\BlackbaudExtendSocialite@handle'
    ],
];

# configure in services.php
'blackbaud' => [
    'client_id' => env('BLACKBAUD_KEY'),
    'client_secret' => env('BLACKBAUD_SECRET'),
    'redirect' => env('BLACKBAUD_REDIRECT_URI'),
]

# start building
return Socialite::driver('blackbaud')->redirect();
