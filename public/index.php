<?php declare(strict_types=1); // public/index.php

use NamCao\Framework\Http\Request;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$request = Request::createFromGlobals();

dd($request);

// request received

// perform some logic

// send response (string of content)
echo 'Hello World';