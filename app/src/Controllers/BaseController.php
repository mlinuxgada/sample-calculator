<?php

/**
 * Mihail Krastev <mlinuxgada@gmail.com>
 *
 * Controller Calc Class
 */

namespace TechPods\SampleCalc\Controllers;

use \Slim\Container;
use \Slim\Http\Request;
use \Slim\Http\Response;

/**
 * Base Controller Class
 * Prepares/sets base site data, like title, and container, for future use
 */
abstract class BaseController
{

    /**
     *
     * @var Container $ci
     */
    protected $ci;

    /**
     *
     * @var array|\mixed $data
     */
    protected $data;


    public function __construct(Container $ci)
    {
        $this->ci   = $ci;
        $this->data = [
            'title'                     => 'TechPods Sample Calc',
            'allowed_operaions'         => $this->ci->config['allowed_operaions'],
        ];

    }
    
    public function __invoke(Request $request, Response $response, $args = [])
    {

    }

}
