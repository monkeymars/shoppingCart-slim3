<?php

$app->get('/', ['Cart\Controllers\HomeController', 'index'])->setName('home');

$app->get('/products/{id}', ['Cart\Controllers\ProductController', 'get'])->setName('product.get');

$app->get('/cart', ['Cart\Controllers\CartController', 'index'])->setName('cart.index');

$app->get('/cart/add/{id}/{qty}', ['Cart\Controllers\CartController', 'add'])->setName('cart.add');
