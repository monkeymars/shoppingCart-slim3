<?php

namespace Cart\Controllers;

use Slim\Views\Twig;
use Cart\Models\Product;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class HomeController
{

 function index(Request $request, Response $response, Twig $view, Logger $log, Product $product)
  {
    // your code
    $log->info('HomeController:index-info');

    $products = $product->all();

    $data = array(
        "products" => $products
    );

    return $view->render($response, 'home.twig', $data);
  }
}
