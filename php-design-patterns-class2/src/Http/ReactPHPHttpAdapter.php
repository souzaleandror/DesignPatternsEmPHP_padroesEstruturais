<?php

namespace Alura\DesignPattern\Http;

class ReactPHPHtppAdapter implements HttpAdapter 
{
    public function post(stirng $url, array $data = []): void
    {
        // instancio o react php
        // preaparo os dados 
        // faco a requisicao
        echo "ReactPHP";
    }
}