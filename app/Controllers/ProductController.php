<?php

namespace Cart\Controllers;

use Slim\Router;
use Cart\Models\Product;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ProductController
{

  protected $view;

  public function __construct(Twig $view, Logger $log, Router $router) {
    $this->view = $view;
    $this->log = $log;
    $this->router = $router;
  }

  public function get($id, Request $request, Response $response, Product $product) {
      //your code
      $this->log->info($id);

      // create a stream
      $data = $product->find($id);

      if (!$product) {
        return $response->withRedirect($router->pathFor('home'));
      }

      return $this->view->render($response, 'products/product.twig', [
        'product' => $data,
        'Product' => $product
      ]);

  }
}
