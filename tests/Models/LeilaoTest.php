<?php

namespace TesteUnit\Leilao\tests\Models;

use PHPUnit\Framework\TestCase;
use TesteUnitario\Leilao\Model\Lance;
use TesteUnitario\Leilao\Model\Leilao;
use TesteUnitario\Leilao\Model\Usuario;

class LeilaoTest extends TestCase
{
    /**
     *  @dataProvider geraLance
     */
    public function testLeilaoDeveReceberLances(int $quantidadeLances, Leilao $leilao, array $valores)
    {
        static::assertCount($quantidadeLances, $leilao->getLances());
        foreach ($valores as $i => $valorEsperado) {
            static::assertEquals($valorEsperado, $leilao->getLances()[$i]->getValor());
        }
    }

    public static function geraLance()
    {
        $joao = new Usuario('João');
        $maria = new Usuario('Maria');

        $leilaoCom2Lances = new Leilao('Fiat 147 0KM');
        $leilaoCom2Lances->recebeLance(new Lance($joao, 1000));
        $leilaoCom2Lances->recebeLance(new Lance($maria, 2000));

        $leilaoCom1Lance = new Leilao('Fusca 1972 0KM');
        $leilaoCom1Lance->recebeLance(new Lance($maria, 5000));

        return [
            '2-lances' => [2, $leilaoCom2Lances, [1000, 2000]],
            '1-lance' => [1, $leilaoCom1Lance, [5000]]
        ];
    }
}