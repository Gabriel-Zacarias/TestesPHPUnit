<?php

namespace TesteUnit\Leilao\tests\Service;

use TesteUnitario\Leilao\Model\Lance;
use TesteUnitario\Leilao\Model\Leilao;
use TesteUnitario\Leilao\Model\Usuario;
use TesteUnitario\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    private $leiloeiro;

    protected function setUp(): void
    {
         $this->leiloeiro = new Avaliador();
    }


    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao $leilao)
    {
        // Act - When / Executamos o código a ser testado
        $this->leiloeiro->avalia($leilao);

        $maiorValor = $this->leiloeiro->getMaiorValor();

        // Assert - Then / Verificamos se a saída é a esperada
        self::assertEquals(2500, $maiorValor);

    }

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveEncontrarOMenorValorDeLances(Leilao $leilao)
    {
        // Act - When / Executamos o código a ser testado
        $this->leiloeiro->avalia($leilao);

        $menorValor = $this->leiloeiro->getMenorValor();

        // Assert - Then / Verificamos se a saída é a esperada

        self::assertEquals(1700, $menorValor);

    }

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public  function testAvaliadorDeveBuscar3maioresValores(Leilao $leilao)
    {
        // Act - When / Executamos o código a ser testado
        $this->leiloeiro->avalia($leilao);
        $maiores = $this->leiloeiro->getMaioresLances();

        self::assertCount(3, $maiores);
        self::assertEquals(2500, $maiores[0]->getValor());
        self::assertEquals(2000, $maiores[1]->getValor());
        self::assertEquals(1700, $maiores[2]->getValor());
    }

    public static function leilaoEmOrdemCrescente()
    {
        $leilao = new Leilao('Fiat 147 0km');

        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($ana, 1700));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));

        return [
            [$leilao]
        ];
    }

    public static function leilaoEmOrdemDecrescente()
    {
        $leilao = new Leilao('Fiat 147 0km');

        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($ana, 1700));


        return [
            [$leilao]
        ];
    }

    public static function leilaoEmOrdemAleatoria()
    {
        $leilao = new Leilao('Fiat 147 0km');

        $maria = new Usuario('Maria');
        $joao = new Usuario('Joao');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($ana, 1700));


        return [
            [$leilao]
        ];
    }

    public function entregaLeiloes()
    {
        return [
            [$this->leilaoEmOrdemCrescente()],
            [$this->leilaoEmOrdemDecrescente()],
            [$this->leilaoEmOrdemAleatoria()],
        ];
    }
}