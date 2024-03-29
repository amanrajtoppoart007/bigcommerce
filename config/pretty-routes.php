<?php

return [

    /**
     * The endpoint to access the routes.
     */
    'url' => 'pretty-routes',

    /**
     * The middleware(s) to apply before attempting to access routes page.
     */
    'middlewares' => ['api'],

    /**
     * Indicates whether to enable pretty routes only when debug is enabled (APP_DEBUG).
     */
    'debug_only' => true,

    /**
     * The methods to hide.
     */
    'hide_methods' => [
        'HEAD',
    ],

    /**
     * The routes to hide with regular expression
     */
    'hide_matching' => [
        '#^_debugbar#',
        '#^_ignition#',
        '#^routes$#'
    ],

];
