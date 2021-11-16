<?php

namespace App\Tests\Unit;

use App\Entity\Code;
use PHPUnit\Framework\TestCase;

class CodeTest extends TestCase
{

    protected $code;


    /**
     * Funkcja ustawiająca wartość kodu dla wszystkich testów
     */
    protected function setUp(): void
    {
        $this->code = new Code();
        $this->code->setCodeNr('000000168255001');
    }

    /**
     * Sprawdzenie, czy kod ma 15 znaków
     * @test
     */
    public function isLengthCorrect(){
        $nr = $this->code->getCodeNr();
        $nr = str_split($nr);
        $this->assertCount(15, $nr);
    }

    /**
     * Sprawdzenie, czy kod nie jest konkretnym, złym kodem
     * @test
     */
    public function notEquals(){
        $nr = $this->code->getCodeNr();
        $this->assertNotEquals('00001236256212M', $nr);
    }

    /**
     * Sprawdzenie, czy kod ma odpowiedni pattern
     * @test
     */
    public function startsWith(){
        $nr = $this->code->getCodeNr();
        $this->assertMatchesRegularExpression('/^0000[0-9]+[A-Z0-9]$/', $nr);
    }
}