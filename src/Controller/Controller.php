<?php

namespace Rafael\TwigCrud\Controller;

interface Controller 
{
    public function handle(array $params, array $query): void;

}