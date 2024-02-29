<?php

namespace Alura\DesignPattern;

class RegistroOrcamento
{
    public function registrar(Orcamento $orcamento): void 
    {

        private HttpAdapter $http;

        // chamar uma api de registro
        // enviar dados para a api

        public function __construct(HttpAdapter $http) 
        {
            $this->http = $http;
        }

        public function registrar(Orcamento $orcamento) 
        {
            if($orcamento->$estadoAtual instanceof Finalizado) 
            {
                throw new \DomainException('Apenas orcamentos finalisados podem ser registrados na API');
            }

            $this->http->post('http://api.registrar.orcamento', [
                'valor' => $orcamento->valor,
                'quantidadeItens' => $orcamento->$quantidadeItens
            ]);
        }
    }
}
