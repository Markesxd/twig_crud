<?php

namespace Rafael\TwigCrud\Controller;

class Router
{
    private array $routes = [
        'css' => CssController::class,
        'js' => JsController::class,
        'entity' => EntityController::class,
        'download' => DownloadController::class
    ];

    public function handle()
    {
        $this->readEnv();
        $uri = explode('?', $_SERVER['REQUEST_URI']);
        $params = explode('/', $uri[0]);
        $query = [];
        if(isset($uri[1])){
            foreach(explode('&', $uri[1]) as $stringQuery ){
                [$key, $value] = explode('=', $stringQuery);
                $query[$key] = $value; 
            }
        }
        
        if(!key_exists($params[1], $this->routes)){
            (new ViewController)->handle($params, $query);
            return;
        }
        (new $this->routes[$params[1]])->handle($params, $query);
    }

    private function readEnv(): void
    {
        $f = fopen(__DIR__ . '/../../.env', 'r');
        $lines = explode("\n", fread($f, filesize(__DIR__ . '/../../.env')));
        global $env;
        $env = [];
        foreach($lines as $line){
            [$key, $value] = explode('=', $line);
            $env[$key] = $value;
        }
    }
}