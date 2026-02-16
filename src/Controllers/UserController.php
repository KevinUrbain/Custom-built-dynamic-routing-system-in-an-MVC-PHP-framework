<?php

class UserController
{
    public function index()
    {
        echo "Je suis le UserController et sa méthode index() par défaut";
    }

    public function add()
    {
        echo "Je suis le UserController et sa méthode add()";
    }

    public function findById($id)
    {
        echo "Je suis le UserController et sa méthode findById où \$id vaut {$id}";
    }

    public function test($param1, $param2, $param3)
    {
        echo "Je suis le UserController et sa méthode test où \$param1, \$param2, \$param3 vaut respectivement {$param1}, {$param2}, {$param3}";
    }
}