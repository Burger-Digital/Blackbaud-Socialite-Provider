# Install with composer
```
composer require burger-digital/blackbaud-socialite-provider
```

# Register in EventServiceProvider.php
```PHP
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        'SocialiteProviders\Blackbaud\BlackbaudExtendSocialite@handle'
    ],
];
```

# Configure in services.php
```PHP
'blackbaud' => [
    'client_id' => env('BLACKBAUD_KEY'),
    'client_secret' => env('BLACKBAUD_SECRET'),
    'redirect' => env('BLACKBAUD_REDIRECT_URI'),
]
```

# Start building
```PHP
return Socialite::driver('blackbaud')->redirect();
```
