<?php 

namespace NamCao\Framework\Routing;

use NamCao\Framework\Http\Request;

interface RouterInterface {
    public function dispatch(Request $request);
}