<?php

return [

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'ldap',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'ldap' => [
            'driver' => 'ldap',
            'rules' => [],
            'model' => LdapRecord\Models\ActiveDirectory\User::class,
            'scopes' => [
                Jitterbug\Scopes\AdldapLimitationScope::class,
            ],
            'database' => [
                'model' => Jitterbug\Models\User::class,
                'sync_passwords' => true,
                'sync_attributes' => [
                    'username' => 'samaccountname',
                    'first_name' => 'givenname',
                    'last_name' => 'sn',
                    'email' => 'mail',
                ],
                'sync_existing' => [
                    'username' => 'samaccountname',
                ],
            ],
        ],

        'users' => [
            'driver' => env('APP_AUTH', 'ldap'),
            'model' => Jitterbug\Models\User::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'email' => 'auth.emails.password',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

];
