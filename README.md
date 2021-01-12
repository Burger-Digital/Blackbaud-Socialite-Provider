# install
composer require burger-digital/blackbaud-socialite-provider

# register
```PHP
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        'SocialiteProviders\Blackbaud\BlackbaudExtendSocialite@handle'
    ],
];
```
# configure in services.php
```PHP
'blackbaud' => [
    'client_id' => env('BLACKBAUD_KEY'),
    'client_secret' => env('BLACKBAUD_SECRET'),
    'redirect' => env('BLACKBAUD_REDIRECT_URI'),
]
```

# start building
```PHP
return Socialite::driver('blackbaud')->redirect();
```
