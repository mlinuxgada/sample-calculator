<?php

require_once __DIR__.'/../vendor/autoload.php';

define('ROOT_PATH', dirname(__DIR__));
define('CONFIG_PATH', ROOT_PATH . '/config');
define('INDEX_PATH', __DIR__);
define('VIEWS_PATH', ROOT_PATH . '/app/views');
define('LOG_PATH', ROOT_PATH . '/logs');

require_once CONFIG_PATH . '/config.php';

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails'               => $envConfig['development'] ?? false,
        'determineRouteBeforeAppMiddleware' => true,
    ],
    'config' => $envConfig,
]);

$container = $app->getContainer();

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(VIEWS_PATH, [
        //'cache' => CACHE_PATH
    ]);

    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

    return $view;
};

$container['logger'] = function($container) {
    $logger = new \Monolog\Logger('logger');
    $file_handler = new \Monolog\Handler\StreamHandler(LOG_PATH.'/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
};

require ROOT_PATH . '/app/routes/routes.php';

$info = parse_url($_SERVER['REQUEST_URI']);

if (php_sapi_name() == 'cli-server' && strstr($info['path'], 'assets'))
{
    if (file_exists(ROOT_PATH.'/public/'.$info['path']))
    {
        return false;
    }

}
else
{
    $app->run();
}
