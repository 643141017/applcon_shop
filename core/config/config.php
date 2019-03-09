<?php

return [
    /**
     * The database credentials
     */
    'database' => [
        'mysql' => [
            'host'     => env('DB_HOST'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'dbname'   => env('DB_DATABASE'),
            'charset'  => env('DB_CHARSET'),
        ],
        
        //table prefix
        'prefix'   => env('DB_TABLEPREFIX')
    ],

    /**
     * Application settings
     */
    'application' => [
        /**
         * The site name, you should change it to your name website
         */
        'name' => 'Applcon',

        /**
         * In a few words, explain what this site is about.
         */
        'tagline'   => 'Applcon 跨境电商',
        'publicUrl' => env('APP_URL'),

        /**
         * Please don't change it
         */
        'httpStatusCode' => 200, // 503
        'modelsDir'      => app_path('core/common/models/'),
        'baseUri'        => env('APP_BASE_URI'),
        'view' => [
            'viewsDir'          => app_path('views/'),
            'compiledPath'      => content_path('cache/volt/'),
            'compiledSeparator' => '_',
            'compiledExtension' => '.php',
            'paginator'         => [
                'limit' => 10,
            ],
        ],
        'dataDir' => app_path('core/data/'),
        'repo'    => env('APP_REPO', 'https://github.com/applcon'),

        // @todo Move to the database
        // seconds
        'passwdResetInterval' => 10,

        /**
         * Change URL cdn if you want it
         */
        'staticBaseUri' => env('APP_STATIC_URL'),

        /**
         * For developers: Applcon debugging mode.
         *
         * Change this to true to enable the display of notices during development.
         * It is strongly recommended that plugin and theme developers use
         * in their development environments.
         */
        'debug' => env('APP_DEBUG'),

        /**
         * Set the password hashing factor
         *
         */
        'hashingFactor' => env('SECURITY_HASHING_FACTOR'),

        'timezone' => env('APP_TIMEZONE', 'UTC'),

        /**
         * Authentication Unique Keys and Salts. Change these to different unique key!
         *
         */
        'cryptSalt' => env('APP_SALT'),

        /**
         * Time life cookie default is 8 day, you can change anything day
         *
         */
        'cookieLifetime' => env('COOKIE_LIFETIME'),

        'session' => [
            'adapter' => env('SESSION_DRIVER'),
            'domain'  => env('SESSION_DOMAIN'),
            'options' => [
                'host'      => env('SESSION_HOST'),
                'port'      => env('SESSION_PORT'),
                'index'     => env('SESSION_INDEX'),
                'prefix'    => env('SESSION_PREFIX'),
                'lifetime'  => env('SESSION_LIFETIME'),
                'uniqueId'  => env('SESSION_UNIQUE_ID'),
            ],
        ],

        'viewCache' => [
            'lifetime' => env('VIEW_CACHE_LIFETIME'),
            'prefix'   => env('VIEW_CACHE_PREFIX'),
            'adapter'  => env('VIEW_CACHE_DRIVER'),
            'cacheDir' => content_path('cache/html/'),
            'force'    => env('VIEW_CACHE_FORCE'),
        ],

        /**
         * Improving Performance with Cache
         *
         */
        'dataCache' => [
            'frontend' => env('DATA_CACHE_FRONTEND'),
            'backend'  => env('DATA_CACHE_DRIVER'),
            'lifetime' => env('DATA_CACHE_LIFETIME'),
            'cacheDir' => content_path('cache/data/'),
            'force'    => env('DATA_VIEW_CACHE_FORCE'),
        ],

        /**
         * You can see from
         *
         */
        'logger' => [
            'path'   => content_path('logs/'),
            'format' => env('LOGGER_FORMAT'),
            'level'  => env('LOGGER_LEVEL'),
        ],
    ],

    'models' => [
        'metadata' => [
            'adapter' => env('METADATA_DRIVER'),
        ]
    ],

    /**
     * You need to change mail parameters below
     *
     */
    'mail' => [
        'templatesDir' => 'mail/',
        'fromName'     => env('MAIL_FROM_NAME'),
        'fromEmail'    => env('MAIL_FROM_ADDRESS'),
        'smtp' => [
            'server'   => env('MAIL_HOST'),
            'port'     => env('MAIL_PORT'),
            'security' => env('MAIL_ENCRYPTION'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
        ]
    ],
    /**
     * Your client ID and client secret keys come from
     *
     */
    'github' => [
        'clientId'     => env('GITHUB_CLIENT_ID'),
        'clientSecret' => env('GITHUB_SECRET'),
        'redirectUri'  => env('GITHUB_REDIRECT_URI'),
        'scopes'       => ['user', 'email']
    ],

    /**
     * Your client ID and client secret keys come from
     *
     */
    'facebook' => [
        'clientId'     => env('FACEBOOK_CLIENT_ID'),
        'clientSecret' => env('FACEBOOK_SECRET'),
        'redirectUri'  => env('FACEBOOK_REDIRECT_URI')
    ],

    /**
     * Set languages you want to it, you can see example
     *
     */
    'language' => [
        'code'    => env('LANG_CODE'),
        'gettext' => env('LANG_USE_GETTEXT'),
    ],

    /**
     * Set theme you want to use
     *
     */
    'theme' => env('THEME_CODE'),

    /**
     * Set editor you want to use
     *
     */
    'editor' => 'ckeditor',

    /**
     * The parameter you get form
     *
     */
    'googleAnalytic' => env('ANALYTIC_ID'),

    'analytic' => [
        'clientId'     => env('ANALYTIC_CLIENT_ID'),
        'clientSecret' => env('ANALYTIC_SECRET'),
        'redirectUri'  => env('ANALYTIC_REDIRECT_URI'),
    ],

    'beanstalk' => [
        'enabled' => env('BEANSTALK_ENABLED'),
        'host'    => env('BEANSTALK_HOST'),
        'port'    => env('BEANSTALK_PORT'),
    ],

    /**
     * The Elasticsearch parameters. You can change it or not
     *
     */
    'elasticsearch' => [
        'index' => env('ELASTIC_INDEX'),
        'type'  => env('ELASTIC_TYPE'),
    ],
];
