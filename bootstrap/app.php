<?php

use Cart\App;

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new App;

require __DIR__ . '/../app/routes.php';
