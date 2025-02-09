<?php

namespace NamCao\Framework\Http;

class HttpException extends \Exception {
    private $statusCode = 404;

    public function setStatusCode(int $statusCode) {
        $this->statusCode = $statusCode;
    }

    public function getStatusCode() {
        return $this->statusCode;
    }
}