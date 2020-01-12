<?php

use TechPods\SampleCalc\Controllers\CalculatorController;

$app->get('/calculator', CalculatorController::class . ':indexAction')->setName('index');
$app->post('/calculator/result', CalculatorController::class . ':showResultAction')->setName('calculator-result');
