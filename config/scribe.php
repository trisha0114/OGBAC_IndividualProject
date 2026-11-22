<?php

use Knuckles\Scribe\Config\AuthIn;
use Knuckles\Scribe\Config\Defaults;
use Knuckles\Scribe\Extracting\Strategies;

use function Knuckles\Scribe\Config\configureStrategy;

return [

    /*
    |--------------------------------------------------------------------------
    | Documentation Information
    |--------------------------------------------------------------------------
    */

    'title' => 'PoolDesk API Documentation',

    'description' => 'API documentation for PoolDesk - Swimming Pool Management and Customer Transaction System.',

    'intro_text' => <<<'INTRO'
This documentation provides information about the PoolDesk API.

PoolDesk is a Swimming Pool Management and Customer Transaction System.

You can use this documentation to understand the available API endpoints,
request parameters, authentication requirements, and response formats.
INTRO,

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    */

    'base_url' => config('app.url'),

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    */

    'routes' => [
        [
            'match' => [
                'prefixes' => ['api/*'],
                'domains' => ['*'],
            ],

            'include' => [],

            'exclude' => [],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Documentation Output
    |--------------------------------------------------------------------------
    */

    'type' => 'laravel',

    'theme' => 'default',

    'static' => [
        'output_path' => 'public/docs',
    ],

    'laravel' => [
        'add_routes' => true,
        'docs_url' => '/docs',
        'assets_directory' => null,
        'middleware' => [],
    ],

    'external' => [
        'html_attributes' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Try It Out
    |--------------------------------------------------------------------------
    */

    'try_it_out' => [
        'enabled' => true,
        'base_url' => null,
        'use_csrf' => false,
        'csrf_url' => '/sanctum/csrf-cookie',
    ],

    /*
    |--------------------------------------------------------------------------
    | API Authentication
    |--------------------------------------------------------------------------
    */

    'auth' => [
        'enabled' => true,

        // Public endpoints are not authenticated by default.
        'default' => false,

        // PoolDesk uses JWT Bearer Token authentication.
        'in' => AuthIn::BEARER->value,

        'name' => 'token',

        // Optional token for Scribe response generation.
        'use_value' => env('SCRIBE_AUTH_KEY'),

        'placeholder' => '{YOUR_JWT_TOKEN}',

        'extra_info' => 'To authenticate, log in using the PoolDesk login endpoint and copy the JWT token from the response. Use this token as a Bearer token in the Authorization header.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Example Languages
    |--------------------------------------------------------------------------
    */

    'example_languages' => [
        'bash',
        'javascript',
    ],

    /*
    |--------------------------------------------------------------------------
    | Postman Collection
    |--------------------------------------------------------------------------
    */

    'postman' => [
        'enabled' => true,

        'overrides' => [
            // 'info.version' => '2.0.0',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | OpenAPI Specification
    |--------------------------------------------------------------------------
    */

    'openapi' => [
        'enabled' => true,

        'version' => '3.0.3',

        'overrides' => [
            // 'info.version' => '2.0.0',
        ],

        'generators' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Documentation Groups
    |--------------------------------------------------------------------------
    */

    'groups' => [
        'default' => 'PoolDesk API Endpoints',

        'order' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    */

    'logo' => false,

    /*
    |--------------------------------------------------------------------------
    | Last Updated
    |--------------------------------------------------------------------------
    */

    'last_updated' => 'Last updated: {date:F j, Y}',

    /*
    |--------------------------------------------------------------------------
    | Example Data
    |--------------------------------------------------------------------------
    */

    'examples' => [
        'faker_seed' => 1234,

        'models_source' => [
            'factoryCreate',
            'factoryMake',
            'databaseFirst',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Extraction Strategies
    |--------------------------------------------------------------------------
    */

    'strategies' => [

        'metadata' => [
            ...Defaults::METADATA_STRATEGIES,
        ],

        'headers' => [
            ...Defaults::HEADERS_STRATEGIES,

            Strategies\StaticData::withSettings(data: [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]),
        ],

        'urlParameters' => [
            ...Defaults::URL_PARAMETERS_STRATEGIES,
        ],

        'queryParameters' => [
            ...Defaults::QUERY_PARAMETERS_STRATEGIES,
        ],

        'bodyParameters' => [
            ...Defaults::BODY_PARAMETERS_STRATEGIES,
        ],

        'responses' => configureStrategy(
            Defaults::RESPONSES_STRATEGIES,

            Strategies\Responses\ResponseCalls::withSettings(
                only: ['GET *'],

                config: [
                    'app.debug' => false,
                ]
            )
        ),

        'responseFields' => [
            ...Defaults::RESPONSE_FIELDS_STRATEGIES,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Transactions
    |--------------------------------------------------------------------------
    */

    'database_connections_to_transact' => [
        config('database.default'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Fractal
    |--------------------------------------------------------------------------
    */

    'fractal' => [
        'serializer' => null,
    ],

];
