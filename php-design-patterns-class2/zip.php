<?php

require_once 'vendor/autoload.php';

$ocamentoZip = new \Alura\DesignPattern\Relatorio\OrcamentoZip();
$orcamento = new \Alura\DesignPattern\Orcamento();
$orcamento->valor(500);

$ocamentoZip->exportar($orcamento);