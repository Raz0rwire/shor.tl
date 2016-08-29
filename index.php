<?php

require_once 'vendor/autoload.php';

$config = array_merge(include('config/database.php'), include('config/defaults.php'));

print app(
    $config,
    instantiate_class('\Shortl\Shortl\Infrastructure\RequestParser'),
    instantiate_class('\Shortl\Shortl\Infrastructure\ActionMapper'),
    instantiate_class('\Shortl\Shortl\Infrastructure\ResponseFactory')
);
exit;

