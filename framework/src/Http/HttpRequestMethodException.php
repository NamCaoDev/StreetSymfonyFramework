<?php

namespace NamCao\Framework\Http;

class HttpRequestMethodException extends \Exception {
    private $statusCode = 400;

    public function setStatusCode(int $statusCode) {
        $this->statusCode = $statusCode;
    }

    public function getStatusCode() {
        return $this->statusCode;
    }
}