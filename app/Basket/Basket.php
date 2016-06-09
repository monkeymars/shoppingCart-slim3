<?php

namespace Cart\Basket;

use Cart\Models\Product;
use Cart\Support\Storage\Contracts\StorageInterface;
use Cart\Basket\Exceptions\QuantityExceedException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Basket
{

  protected $storage;
  protected $product;

  public function __construct(StorageInterface $storage, Product $product)
  {
    $this->storage = $storage;
    $this->product = $product;
  }

  public function add($product, $qty)
  {
    if ($this->has($product)) {
      $qty = $this->get($product)['qty'] + $qty;
      echo "ada";
    }
    //print_r($product);
    $this->update($product, $qty);
  }

  public function update($product, $qty)
  {
    // if (!$this->product->find($product->id)->hasStock($qty)) {
    //    throw new QuantityExceedException;
    // }

    if ($qty === 0) {
      $this->remove($product);
      return;
    }

    $this->storage->set($product['id'], [
        'product_id' => $product['id'],
        'qty' => (int) $qty,
    ]);

  }

  public function remove(Product $product)
  {
    $this->storage->unset($product['id']);
  }

  public function has($product)
  {
    return $this->storage->exists($product['id']);
  }

  public function get($product)
  {
    return $this->storage->get($product['id']);
  }

  public function clear()
  {
    $this->storage->clear();
  }

  public function all()
  {
    $ids = [];
    $items = [];

    // problem fixed
    foreach ($this->storage->all() as $product) {
      $ids[] = $product['product_id'];
    }

    // problem is here
    $products = $this->product->getAll($ids);

    foreach ($products as $product) {
      $product['qty'] = $this->get($product)['qty'];
      $items[] = $product;
    }

    return $items;

  }

  public function itemCount(){
    return count($this->storage);
  }

}
