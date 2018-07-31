<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

use Auth\Middleware\TokenMiddleware;
use Auth\Middleware\TokenMiddlewareFactory;

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

return [
    'auth' => [
        TokenMiddleware::class => [
            TokenMiddleware::SIGN_KEY => getenv('JWT_SIGN_KEY'),
            TokenMiddleware::SIGN_PASSPHRASE => getenv('JWT_SIGN_PASSPHRASE'),
        ],
    ],
    'dependencies' => [
        'factories' => [
            TokenMiddleware::class => TokenMiddlewareFactory::class,
        ],
    ],
];