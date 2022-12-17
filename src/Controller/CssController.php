<?php

namespace Rafael\TwigCrud\Controller;

class CssController implements Controller
{
    public function handle(array $params, array $query): void
    {
        header("Content-Type: text/css");
        echo include(__DIR__ . "/../View/css/$params[2].css");
    }
}