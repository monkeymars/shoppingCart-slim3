<?php

namespace Cart\Basket\Exceptions;

use Exception;

class QuantityExceedException extends Exception
{

  protected $message = " Stok batas maksimum produk ini tepenuhi.";

}
