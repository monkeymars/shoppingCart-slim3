<?php

namespace Cart\Models;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Product
{

  /*
   * Stock Rule
   */

  // product hasLowStock
  public function hasLowStock($id)
  {
    $product = $this->find($id);
    if ($this->outOfStock($id)) {
      return false;
    }
    return (bool) ($product['stock'] <= 5);
  }

  // product outOfStock
  public function outOfStock($id){
    $product = $this->find($id);
    return $product['stock'] === 0;
  }

  // product inStock
  public function inStock($id) {
    $product = $this->find($id);
    return $product['stock'] >= 1;
  }

  // product hasStock
  public function hasStock($qty) {
    $product = $this->find($id);
    return $product['stock'] >= $qty;
  }

  // Get all product
  public function all() {
    $opts = array(
      'http'=>array(
        'method'=>"GET",
        'header'=>"Accept: application/json"
      )
    );
    $context = stream_context_create($opts);
    $file = file_get_contents('YOUR-API-URL', false, $context);
    $products = json_decode($file, JSON_PRETTY_PRINT);

    return $products;
  }

  // Get product by $id
  public function find($id) {
    $opts = array(
      'http'=>array(
        'method'=>"GET",
        'header'=>"Accept: application/json"
      )
    );
    $context = stream_context_create($opts);
    $file = file_get_contents('YOUR-API-URL', false, $context);
    $product = json_decode($file, JSON_PRETTY_PRINT);

    return $product;

  }

  public function getAll($ids) {

    $products = [];

    $opts = array(
      'http'=>array(
        'method'=>"GET",
        'header'=>"Accept: application/json"
      )
    );

    $context = stream_context_create($opts);

    foreach ($ids as $id) {
        $file = file_get_contents('YOUR-API-URL', false, $context);
        $product = json_decode($file, JSON_PRETTY_PRINT);
        $products[] = $product;
    }

    return $products;

  }

}
