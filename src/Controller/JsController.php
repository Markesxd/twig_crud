<?php

namespace Rafael\TwigCrud\Controller;

class JsController implements Controller
{
    public function handle(array $params, array $query): void
    {
        header("Content-Type: aplication/javascript");
        echo include(__DIR__ . "/../View/js/$params[2].js");
    }
}