<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'telegram' => [
    'enable' => env('TELEGRAM_ENABLE', true),
    'token' => env('TELEGRAM_BOT_TOKEN', '8401912186:AAGcn69z65BDhMHkkPjJ19mivp3F3UfGB1g'),
    'chat_id_personal' => env('TELEGRAM_CHAT_ID_PERSONAL', '1302540004'),
    'chat_id_group' => env('TELEGRAM_CHAT_ID_GROUP', '-4652733195'),
],


];
