<?php declare(strict_types=1); // public/index.php

use NamCao\Framework\Http\Kernel;
use NamCao\Framework\Http\Request;

require_once dirname(__DIR__) . '/vendor/autoload.php';

// request received
$request = Request::createFromGlobals();

// perform some logic
$kernel = new Kernel();

// send response (string of content)
$response = $kernel->handle($request);


$response->send();