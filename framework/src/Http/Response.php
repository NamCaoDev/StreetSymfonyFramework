<?php

namespace NamCao\Framework\Http;

class Response {
   
   public const HTTP_INTERNAL_SERVER_ERROR = 500;

   public function __construct(
       private string $content = '',
       private int $statusCode = 200,
       private array $headers = [],
   ) {
        // Must be set before sending content
        // So best to create on instantiation like here
        http_response_code($this->statusCode);
   }

   public function send(): void {
     echo $this->content;
   }
}