<?php

namespace Cart\Controllers;

use Slim\Router;
use Slim\Views\Twig;
use Cart\Basket\Basket;
use Cart\Models\Product;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class CartController
{

  protected $basket;
  protected $product;

  public function __construct(Basket $basket, Product $product)
  {
    $this->basket = $basket;
    $this->product = $product;
  }

  public function index(Request $request, Response $response, Twig $view)
  {

    return $view->render($response, 'cart/index.twig');
  }

  public function add($id, $qty, Request $request, Response $response, Twig $view, Router $router, Logger $log)
  {

    $log->info('CartController:add-info');
    $product = $this->product->find($id);

    if (!$product) {
      return $response->withRedirect($router->pathFor('home'));
    }

    $dataToAdd = array(
      'name' => $product['name'],
      'id' => $product['id'],
      'stock' => $product['stock'],
      'purchase' => $product['purchase']
    );

    try {
      $this->basket->add($dataToAdd, $qty);
    } catch (QuantityExceedException $e) {
      //
    }

    return $response->withRedirect($router->pathFor('cart.index'));

  }

}
