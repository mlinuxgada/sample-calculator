<?php

/**
 * Mihail Krastev <mlinuxgada@gmail.com>
 *
 * Controller Calc Class
 */

namespace TechPods\SampleCalc\Controllers;

use \Slim\ContainerInterface;
use \Slim\Http\Request;
use \Slim\Http\Response;

use TechPods\SampleCalc\Services\Calculator;

/**
 * Main CalculatorController class. Responsible for rendering the
 * form for initial numbers and desired operarion and after calc op
 * rendering the result.
 *
 */
class CalculatorController
    extends BaseController
{

    /**
     * Controller method responsible for rendering the input form
     *
     * @param Request $request
     * @param Response $response
     * @param array $args- by default its empty array
     */
    public function indexAction(Request $request, Response $response, $args = [])
    {
        return $this->ci->view->render($response, 'calculator_index.html', $this->data);
    } 

    /**
     * Controller method responsible for calling the Calculator Service, calculating
     * and rendering the result.
     * IMPORTANT: Atm, if any err\ex happened, will be redirected into main input form!!!
     *
     * @param Request $request
     * @param Response $response
     * @param array $args- by default its empty array
     */
    public function showResultAction(Request $request, Response $response, $args = [])
    {
        $params = $request->getParams();


        $calc = new Calculator();

        try
        {
            $this->data['result'] = $calc->process($params['operation'], $params['numbers']);
        }
        catch(\Exception $ex)
        {

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/calculator');
            ;
        }

        return $this->ci->view->render($response, 'calculator_result.html', $this->data);
    }

}
