<?php

require_once 'vendor/autoload.php';

$config = array_merge(include('config/database.php'), include('config/defaults.php'));

use Shortl\Shortl\Contracts\Request;
use Shortl\Shortl\Contracts\Response;

use Shortl\Shortl\Infrastructure\RequestParser;
use Shortl\Shortl\Infrastructure\ActionMapper;
use Shortl\Shortl\Infrastructure\ResponseFactory;

use Shortl\Shortl\Infrastructure\ActionNotFound;
use Shortl\Shortl\Infrastructure\EntityNotFound;


/**
 * @param Response $response
 * @param string $type
 * @param int $status
 * @return string
 */
function not_found(Response $response, string $type, array $config, int $status = 302) : string
{
    return $response('', ['Location' => $config['redirect_url'], 'Type-Of-Missing' => $type], $status);
}


/**
 * @param array $config
 * @param Request $parser
 * @param ActionMapper $mapper
 * @param Response $response
 * @return string
 */
function app(array $config, Request $parser, ActionMapper $mapper, Response $response) : string
{
    try {

        $request = $parser($_SERVER);
        $action = $mapper($request);

        return $action($request, $response, $config);

    } catch (ActionNotFound $e) {

        return not_found($response, 'action', $config, 301);

    } catch (EntityNotFound $e) {

        return not_found($response, 'entity', $config);

    }
}

print app($config, new RequestParser(), new ActionMapper(), new ResponseFactory());
exit;

