<?php

namespace NamCao\Framework\Http;

class Kernel {
    public function handle(Request $request): Response 
    {
        $content = '<h1>Nam Dep Zai 2</h1>';

        return new Response($content);
    }
}