<?php

namespace TesteUnitario\Leilao\Service;

use TesteUnitario\Leilao\Model\Lance;
use TesteUnitario\Leilao\Model\Leilao;

class Avaliador
{
    private $maiorValor = -INF;
    private $menorValor = INF;
    private $maioresLances;

    public function avalia(Leilao $leilao)
    {
        if (empty($leilao->getLances())) {
            throw new \DomainException('Não é possível avaliar leilão vazio');
        }
        foreach ($leilao->getLances() as $lance){
            if($lance->getValor() > $this->maiorValor){
                $this->maiorValor = $lance->getValor();
            }
            if ($lance->getValor() < $this->menorValor) {
                $this->menorValor = $lance->getValor();
            }
        }
        $lances = $leilao->getLances();
        usort($lances, function (Lance $lance1, Lance  $lance2){
            return $lance2->getValor() - $lance1->getValor();
            // Do maior valor para o menor
        });
        $this->maioresLances = array_slice($lances, 0, 3);
    }

    public function getMaiorValor(): float
    {
        return $this->maiorValor;
    }

    public function getMenorValor()
    {
        return $this->menorValor;
    }

    public function getMaioresLances()
    {
        return $this->maioresLances;
    }
}