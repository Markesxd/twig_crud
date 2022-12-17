<?php

namespace Rafael\TwigCrud\Controller;

use Rafael\TwigCrud\Model\Entity;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ViewController implements Controller
{
    private array $pages = [
        '' => 'home',
        'adicionar' => 'add',
        'editar' => 'edit',
        'entidade' => 'details'
    ];

    public function handle(array $params, array $query): void
    {

        if(!key_exists($params[1], $this->pages)){
            http_response_code(404);
            return;
        }

        $loader = new FilesystemLoader( __DIR__ . '/../View/');
        $twig = new Environment($loader);
        $action = $this->pages[$params[1]];
        $twig->load($action . '.html.twig')->display($this->$action($params, $query));
    }

    private function home($params, $query): array
    {
        $page = $query['page'] ?? 1;
        if($page < 1) $page = 1;
        $entities = Entity::getEntitiesAsArray($page);
        if(count($entities) === 0){
            $location = $_SERVER['HTTP_REFERER'] ?? '/adicionar';
            header("Location: $location");
            exit;
        }
        return ['entities' => $entities, 'page' => $page];
    }

    private function add($params, $query):array
    {
        return [];
    }

    private function edit($params, $query): array
    {
        return ['entity' => Entity::getEntityAsArray($params[2])];
    }

    private function details($params, $query): array
    {
        return ['entity' => Entity::getEntityAsArray($params[2])];
    }
}