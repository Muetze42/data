#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use NormanHuth\ConsoleApp\App;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

/** @noinspection PhpUnhandledExceptionInspection */
new App('Data', 1, 'all');
