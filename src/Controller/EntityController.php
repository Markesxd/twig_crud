<?php

namespace Rafael\TwigCrud\Controller;

use Rafael\TwigCrud\Controller\Controller;
use Rafael\TwigCrud\Model\Entity;

class EntityController implements Controller
{
    public function handle(array $params, array $query): void
    {
        switch($_SERVER['REQUEST_METHOD']){
            case 'POST':
                if($_POST['_method'] === 'put'){
                    $this->put();
                    return;
                }
                $this->post();
            break;
            case 'DELETE':
                if(!isset($params[2])){
                    http_response_code(400);
                    return;
                }
                $this->remove($params[2]);
            break;
        }
    }

    private function post(): void
    {
        $entity = new Entity;
        $entity->setAll($_POST)->handleFile()->create();
        header("Location: /");
    }

    private function remove(string $id): void
    {
        $entity = new Entity;
        $entity->setAll(['id' => $id])->removeFile()->remove($id);
    }

    private function put(): void
    {
        $entity = new Entity;
        $entity->setAll($_POST)->changeFile()->edit();
        header("Location: /");
    }
}