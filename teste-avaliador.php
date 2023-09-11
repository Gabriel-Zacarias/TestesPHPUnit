<?php

use TesteUnitario\Leilao\Model\Lance;
use TesteUnitario\Leilao\Model\Leilao;
use TesteUnitario\Leilao\Model\Usuario;
use TesteUnitario\Leilao\Service\Avaliador;

require 'vendor/autoload.php';

$leilao = new Leilao('Fiat 147 0km');


$maria = new Usuario('Maria');
$joao = new Usuario('Joao');

$leilao->recebeLance(new Lance($joao, 2000));
$leilao->recebeLance(new Lance($maria, 2500));

$leiloeiro = new Avaliador();

$leiloeiro->avalia($leilao);

$maiorValor = $leiloeiro->getMaiorValor();
$valorEsperado = 2500;
if($maiorValor == $valorEsperado){
    echo 'Teste OK';
} else {
    echo 'Teste Falhou';
}